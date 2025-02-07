<?php

namespace App\Service\extend;

use App\Service\InterfaceService as ServiceInterfaceService;

interface IServiceUser extends ServiceInterfaceService
{
    public function activeUser($hash);
    public function changeRole($hash, $role);
}
