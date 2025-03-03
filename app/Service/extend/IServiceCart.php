<?php

namespace App\Service\extend;

use App\Service\InterfaceService as ServiceInterfaceService;

interface IServiceCart extends ServiceInterfaceService
{
    public function managerOwnCart($id, $id_user);
    public function managerOwnCarts($id_user);
}
