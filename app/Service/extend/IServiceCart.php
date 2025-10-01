<?php

namespace App\Service\extend;

use App\Service\InterfaceService as ServiceInterfaceService;

interface IServiceCart extends ServiceInterfaceService
{
    public function managerOwnCart($id, $idUser);
    public function managerOwnCarts($idUser);
}
