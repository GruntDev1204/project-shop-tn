<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Category;
use App\Repository\extend\ICategoryRepo;

class CategoryRepo implements ICategoryRepo
{
    public function getAll($req)
    {
        return Category::all();
    }

    public function findById($id)
    {
        $data = Category::find($id);
        if (!$data) {
            throw new APIException(404, "data not found!");
        }
        return $data;
    }

    public function create($data)
    {
        $category = Category::create($data);
        return $category;
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
}
