<?php
namespace App\Repository\impl;
use App\Models\Category;
use App\Repository\extend\ICategoryRepo;

class CategoryRepo implements ICategoryRepo
{
    public function getAll()
    {
        return Category::all();
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function create($data)
    {
        $category = Category::create($data);
        return $category;
    }

    public function update($id, $data)
    {
        $category = Category::find($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        if($category === null) return false;

        $category->delete();
        return true;
    }
}
