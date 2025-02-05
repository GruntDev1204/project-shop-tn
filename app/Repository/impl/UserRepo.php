<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Models\Product;
use App\Models\User;
use App\Repository\extend\IUserRepo;

class UserRepo implements IUserRepo
{
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
        return $user;
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
