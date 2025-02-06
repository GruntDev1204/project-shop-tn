<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Http\Requests\UserReq;
use App\Service\extend\IServiceUser;

class UserController extends Controller
{
    protected $userSV;

    public function __construct(IServiceUser $userSV)
    {
        $this->userSV = $userSV;
    }
    public function signup(UserReq $request)
    {
        $data = $request->all();
        $user = $this->userSV->create($data);

        return $this->returnJson($user, 200, "resigter success!");
    }

    public function updateProfile(UpdateUser $request)
    {
        $user = $this->getAuth();
        $data = $request->all();
        $dataUpdate = $this->userSV->update($user->id, $data);

        return $this->returnJson($dataUpdate, 200, "update successful!");
    }
}
