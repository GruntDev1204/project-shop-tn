<?php

namespace App\Service\extend;

use App\Service\InterfaceService as ServiceInterfaceService;

interface IServiceOrder extends ServiceInterfaceService
{
    public function ownOrder($userId, $id);
    public function ownOrders($userId);
}
