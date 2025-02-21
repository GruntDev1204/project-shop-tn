<?php

namespace App\Service\extend;

use App\Service\InterfaceService as ServiceInterfaceService;

interface IServiceUser extends ServiceInterfaceService
{
    public function activeUser($hash);
    public function changeRole($id, $role);
    public function changeStatus($id, $status);
    public function findByHash($hash);
    public function findByEmail($email);
    public function enable2FA($hash);
}
