<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Product;
use App\Models\RoleUser;
use App\Models\User;
use App\Repository\extend\IUserRepo;

class UserRepo implements IUserRepo
{
    private function getRole($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new APIException(404, "data not found!");
        }
        $roleUser = RoleUser::where('user_id', $user->id)->first();
        switch ($data['role']) {
            case 'admin':
                if (!$roleUser) {
                    $roleUser = RoleUser::create([
                        'user_id' => $user->id,
                        'role_id' => 1,
                    ]);
                }
                break;
            case 'customer':
                if (!$roleUser) {
                    $roleUser = RoleUser::create([
                        'user_id' => $user->id,
                        'role_id' => 2,
                    ]);
                }
                break;
            default:
                throw new APIException(404, "role not found!");
        }
    }

    public function getAll() {}

    public function findById($id)
    {
        $data = User::find($id);
        if (!$data) {
            throw new APIException(404, "data not found!");
        }
        return User::find($id);
    }

    public function create($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'password' => bcrypt($data['password']),
        ]);
        $this->getRole($data);

        $userData = [
            'role' => $data['role'],
            'user' => $user
        ];

        return $userData;
    }

    public function update($id, $data)
    {
        $dataUpdate = $this->findById($id);
        $dataUpdate->update([
            'name' => $data['name'],
            'avatar' => $data['avatar'],
        ]);

        return $dataUpdate;
    }

    public function delete($id) {}
}
