<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Cart;
use App\Repository\BaseRepository;
use App\Repository\extend\ICartRepo;

class CartRepo extends BaseRepository implements ICartRepo
{

    private function queryCart()
    {
        return Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.*', 'products.name as product_name', 'products.image');
    }

    private function findCart($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            throw new APIException(404, "cart not found!");
        }
        return $cart;
    }

    public function getAll($req)
    {
        return $this->queryCart()->get();
    }

    public function findById($id)
    {
        $data = $this->queryCart()
            ->where('carts.id', $id)
            ->first();

        if (!$data) {
            throw new APIException(404, "cart not found!");
        }

        return $data;
    }

    public function create($data)
    {
        return Cart::create($data);
    }

    public function update($id, $data)
    {
        $cart = $this->findCart($id);
        $cart->update($data);
        return $cart;
    }

    public function delete($id)
    {
        $cart = $this->findCart($id);
        $cart->delete();
        return true;
    }

    public function managerOwnCart($id, $idUser)
    {
        $data = $this->queryCart()->where('carts.id', $id)->where('carts.user_id', $idUser)->first();

        if (!$data) {
            throw new APIException(404, "cart not found!");
        }

        return $data;
    }

    public function managerOwnCarts($idUser)
    {
        $data = $this->queryCart()->where('carts.user_id', $idUser)->get();
        if ($data->isEmpty()) {
            throw new APIException(404, "cart not found!");
        }

        return $data;
    }

    public function managerOwnCartsById($idUser, array $idCarts)
    {
        $data = $this->queryCart()->whereIn('carts.id', $idCarts)->where('carts.user_id', $idUser)->get();

        if ($data->isEmpty()) {
            throw new APIException(404, "cart not found!");
        }

        $validCartIds = $data->pluck('id')->toArray();
        $invalidIds = array_diff($idCarts, $validCartIds);

        if (!empty($invalidIds)) {
            throw new APIException(403, "Một trong những giỏ hàng đéo phải của mày!");
        }

        return $data;
    }
}
