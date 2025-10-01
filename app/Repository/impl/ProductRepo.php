<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Product;
use App\Repository\BaseRepository;
use App\Repository\extend\IProductRepo;

class ProductRepo extends BaseRepository implements IProductRepo
{
    private function queryData($reqParam, $query, $isPublic = false)
    {
        if (!empty($reqParam['name'])) {
            $query->where('name', 'like', '%' . trim($reqParam['name']) . '%');
        }

        if (!empty($reqParam['origin'])) {
            $query->where('origin', 'like', '%' . trim($reqParam['origin']) . '%');
        }

        if (!empty($reqParam['id_category'])) {
            $query->where('category_id', $reqParam['id_category']);
        }

        if ($isPublic) {
            $query->where('status', true);
        }

        if ((!empty($reqParam['sort_order']) && !empty($reqParam['sort_col'])) && in_array(strtolower($reqParam['sort_order']), ['asc', 'desc'])) {
            $query->orderBy($reqParam['sort_col'], $reqParam['sort_order']);
        }
    }

    public function managerAllProducts($reqParam)
    {
        $query = Product::query();
        $this->queryData($reqParam, $query, false);
        return $this->paginateQuery($reqParam, $query);
    }

    public function getAll($reqParam)
    {
        $query = Product::query();
        $this->queryData($reqParam, $query, true);
        return $this->paginateQuery($reqParam, $query);
    }

    public function findById($id)
    {
        $data = Product::find($id);
        if (!$data) {
            throw new APIException(404, "data not found!");
        }
        return $data;
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function update($id, $data)
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->findById($id);
        $product->delete();
        return true;
    }

    public function changeStatus($id)
    {
        $product = $this->findById($id);
        $product->status = !$product->status;
        $product->save();
        return $product;
    }
}
