<?php

namespace  App\Service\impl;

use App\Exceptions\APIException;
use App\Repository\extend\ICartRepo;
use App\Repository\extend\IProductRepo;
use App\Service\extend\IServiceCart as IServiceCart;

class CartService  implements IServiceCart
{
    private $cartRepo, $productRepo;

    public function __construct(ICartRepo $cartRepo, IProductRepo $productRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->productRepo = $productRepo;
    }

    private function checkProduct($productId, $dataCart)
    {
        $product = $this->productRepo->findById($productId);

        if (!$product->status) {
            throw new APIException(422, "Product is not available now!");
        }

        if ($product->quantity < $dataCart['quantity']) {
            throw new APIException(400, "Not enough stock available!");
        }

        return $product;
    }

    public function getAll($req)
    {
        return $this->cartRepo->getAll($req);
    }

    public function findById($id)
    {
        return $this->cartRepo->findById($id);
    }

    public function managerOwnCart($id, $idUser)
    {
        $cart = $this->findById($id);
        if ($cart->user_id != $idUser) {
            throw new APIException(403, "You don't have permission to access this cart!");
        }

        return $cart;
    }

    public function managerOwnCarts($idUser)
    {
        return $this->cartRepo->managerOwnCarts($idUser);
    }

    public function create($data)
    {
        $product = $this->checkProduct($data['product_id'], $data);

        $finalPrice = $product->price * (1 - $product->discount);
        $data['price'] = $finalPrice;

        return $this->cartRepo->create($data);
    }

    public function update($id, $data)
    {
        $cart = $this->findById($id);
        $product = $this->checkProduct($data['product_id'], $data);

        if ($cart->product_id != $data['product_id']) {
            $data['price'] = $product->price * (1 - $product->discount);
        } else {
            $data['price'] = $cart->price;
        }

        return $this->cartRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->cartRepo->delete($id);
    }
}
