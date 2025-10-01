<?php

namespace App\Service\impl;

use App\Repository\extend\ICategoryRepo;
use App\Service\extend\IServiceCategory;

class CategoryService implements IServiceCategory
{
    private $categoryRepo;

    public function __construct(ICategoryRepo $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }
    public function getAll($req)
    {
        return $this->categoryRepo->getAll($req);
    }

    public function findById($id)
    {
        return $this->categoryRepo->findById($id);
    }

    public function create($data)
    {
        return $this->categoryRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->categoryRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->categoryRepo->delete($id);
    }
}
