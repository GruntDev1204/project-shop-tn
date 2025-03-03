<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface as RepositoryInterface;

interface ICartRepo extends RepositoryInterface
{
    public function  managerOwnCart($id, $id_user);
    public function managerOwnCarts( $id_user);
}
