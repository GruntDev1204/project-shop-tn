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
    public function getAll($req)
    {
        return $this->cartRepo->getAll($req);
    }

    public function findById($id)
    {
        return $this->cartRepo->findById($id);
    }

    public function managerOwnCart($id, $id_user)
    {
        $cart = $this->cartRepo->findById($id);
        if ($cart->user_id != $id_user) {
            throw new APIException(403, "You don't have permission to access this cart!");
        }

        return $this->cartRepo->managerOwnCart($id, $id_user);
    }

    public function managerOwnCarts($id_user)
    {
        return $this->cartRepo->managerOwnCarts($id_user);
    }

    public function create($data)
    {
        $product = $this->productRepo->findById($data['product_id']);

        if (!$product->status) {
            throw new APIException(400, "Product is not available!");
        }

        if ($product->quantity < $data['quantity']) {
            throw new APIException(400, "Not enough stock available!");
        }

        $finalPrice = $product->price * (1 - $product->discount);
        $data['price'] = $finalPrice;

        return $this->cartRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->cartRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->cartRepo->delete($id);
    }
}
