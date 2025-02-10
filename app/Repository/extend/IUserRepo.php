<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface as RepositoryInterface;

interface IUserRepo extends RepositoryInterface
{
    public function activeUser($hash);
    public function changeRole($id, $role);
    public function changeStatus($id, $valueStatus);
}
