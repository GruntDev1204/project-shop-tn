<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UserReq;
use App\Mail\ActiveUser;
use App\Service\extend\IServiceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        return $this->returnJson($user, 201, "resigter success!");
    }

    public function updateProfile(UpdateUser $request)
    {
        $user = $this->getAuth();
        $data = $request->all();
        $dataUpdate = $this->userSV->update($user->id, $data);

        return $this->returnJson($dataUpdate, 200, "update successful!");
    }

    public function getAll()
    {
        $this->authorizeRole('CEO');
        $data = $this->userSV->getAll();
        if (!$data || empty($data)) {
            throw new APIException(500, "failure!");
        }

        return $this->returnJson($data, 200, "success!");
    }

    public function sendMail()
    {
        $user = $this->getAuth();
        if (!$user) {
            throw new AuthException('User not authenticated.');
        }

        $isAdmin = in_array($user->role, ['Admin', 'CEO']);
        if ($isAdmin) {
            $this->userSV->activeUser($user->hash_code);
            return $this->returnJson([
                'role' => $user->role
            ], 200, "you don't need to activate users because you are an admin!");
        } else {
            if ($user->status === 1) {
                return $this->returnJson(null, 202, "your account is already active!");
            }
            Mail::to($user->email)->send(new ActiveUser($user->name, $user->hash_code, 'Active User'));
            return $this->returnJson($user->role, 202, "email sent successfully , please check your email address and continue!");
        }
    }

    public function changeRole($hash, Request $rq)
    {
        $this->authorizeRole('CEO');

        $roleName = $rq->query('role');
        if (!$roleName) {
            throw new APIException(400, "Role is required!");
        }

        $role = $this->userSV->changeRole($hash, $roleName);
        return $this->returnJson($role, 202, "changed role successfully!");
    }

    public function activeUsers($hash_code)
    {
        $this->userSV->activeUser($hash_code);
        return $this->returnJson(null, 202, "active user successfully!");
    }
}
