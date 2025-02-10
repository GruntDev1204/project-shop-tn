<?php

namespace App\Repository\impl;

use App\Exceptions\APIException;
use App\Exceptions\AuthorizeException;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Repository\extend\IUserRepo;
use Carbon\Carbon;
use Illuminate\Support\Str;


class UserRepo implements IUserRepo
{
    private function getRole($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new APIException(404, "user by this email not found!");
        }

        $roleUser = RoleUser::where('user_id', $user->id)->first();
        if (!$roleUser) {
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => 3,
            ]);
        }
    }

    private function findByHash($hash)
    {
        $user = User::where('hash_code', $hash)->first();
        if (!$user) {
            throw new APIException(404, "user by this hash not found!");
        }

        return $user;
    }

    public function changeRole($hash, $roleId)
    {
        $user = $this->findByHash($hash);
        RoleUser::where('user_id', $user->id)->update(['role_id' => $roleId]);

        if ($roleId === 2) {
            $this->activeUser($hash);
        }
        return Role::find($roleId);
    }

    public function getAll()
    {
        return User::all();
    }

    public function findById($id)
    {
        $data = User::find($id);
        if (!$data) {
            throw new APIException(404, "user not found!");
        }
        return User::find($id);
    }

    public function create($data)
    {
        $user = User::create([
            'hash_code' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'password' => bcrypt($data['password']),
            'status' => 0
        ]);
        $this->getRole($data);

        $userData = [
            'role' => 'customers',
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

    public function delete($id)
    {
        $user = $this->findById($id);
        $user->delete();
        return true;
    }

    public function activeUser($hash)
    {
        $user = $this->findByHash($hash);

        if (!$user) {
            throw new APIException(404, "user by this hash not found!");
        }

        if (!in_array($user->status, [0, 1])) {
            throw new AuthorizeException("bạn bị cho cook khỏi server!");
        }

        $user->status = 1;
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
