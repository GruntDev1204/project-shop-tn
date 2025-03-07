<?php

namespace App\Repository\extend;

use App\Repository\RepositoryInterface as RepositoryInterface;

interface IOrderRepo extends RepositoryInterface
{
    public function ownOrder($userId, $id);
    public function ownOrders($userId);
}
