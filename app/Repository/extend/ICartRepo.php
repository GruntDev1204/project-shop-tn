<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface as RepositoryInterface;

interface ICartRepo extends RepositoryInterface
{
    public function  managerOwnCart($id, $idUser);
    public function managerOwnCarts($idUser);
}
