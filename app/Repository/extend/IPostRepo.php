<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface;

interface IPostRepo extends RepositoryInterface
{
    public function getAllOwns($req);
}
