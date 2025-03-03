<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface as RepositoryInterface;

interface IProductRepo extends RepositoryInterface
{
    public function changeStatus($id);
    public function managerAllProducts($reqParam);
}
