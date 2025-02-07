<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface as RepositoryInterface;

interface IUserRepo extends RepositoryInterface
{
    public function activeUser($hash);
    public function changeRole($hash, $role);
}
