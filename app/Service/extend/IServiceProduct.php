<?php

namespace App\Service\extend;

use App\Service\InterfaceService as ServiceInterfaceService;

interface IServiceProduct extends ServiceInterfaceService
{
    public function changeStatus($id);
    public function managerAllProducts($reqParam);
}
