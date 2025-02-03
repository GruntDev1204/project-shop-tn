<?php
namespace App\Repository\impl;

use App\Models\Product;
use App\Repository\extend\IProductRepo;

class ProductRepo implements IProductRepo
{
    public function getAll()
    {
        return Product::all();
    }

    public function findById($id)
    {
        return Product::find($id);
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function update($id, $data)
    {
        $product = $this->findById($id);
        if ($product == null) {
            return false;
        }

        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->findById($id);
        if ($product == null) {
            return false;
        }
        $product->delete();
        return true;
    }


    public function changeStatus($id)
    {
        $product = Product::find($id);
        $product->status = !$product->status;
        $product->save();
    }

}
