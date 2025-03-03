<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Cart;
use App\Repository\BaseRepository;
use App\Repository\extend\ICartRepo;

class CartRepo extends BaseRepository implements ICartRepo
{
    public function getAll($req)
    {
        return Cart::Join('products', 'products.id', '=', 'carts.product_id')->select('carts.*', 'products.name as product_name', 'products.image',)->get();
    }

    public function findById($id)
    {
        $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.*', 'products.name as product_name', 'products.image')
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
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        $category->delete();
        return true;
    }

    public function managerOwnCart($id, $id_user)
    {
        $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.*', 'products.name as product_name', 'products.image')
            ->where('carts.id', $id)->where('carts.user_id', $id_user)->first();

        if (!$data) {
            throw new APIException(404, "cart not found!");
        }

        return $data;
    }

    public function managerOwnCarts($id_user)
    {
        $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.*', 'products.name as product_name', 'products.image')
            ->where('carts.user_id', $id_user)->get();

        if (!$data) {
            throw new APIException(404, "cart not found!");
        }

        return $data;
    }
}
