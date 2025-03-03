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

    public function findByHash($hash)
    {
        $user = User::where('hash_code', $hash)->first();
        if (!$user) {
            throw new APIException(404, "user by this hash not found!");
        }

        return $user;
    }

    public function changeRole($id, $roleId)
    {
        $user = $this->findById($id);
        RoleUser::where('user_id', $user->id)->update(['role_id' => $roleId]);

        if ($roleId === 2) {
            $this->activeUser($user->hash_code);
        }
        return Role::find($roleId);
    }

    public function changeStatus($id, $valueStatus)
    {
        $user = $this->findById($id);
        $user->status = $valueStatus;
        if ($user->status === 2) {
            $this->changeRole($id, 3);
        }
        $user->save();
        return $user;
    }

    public function getAll($req)
    {
        return User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('roles.name', '!=', 'CEO')
            ->select('users.*', 'roles.name as role')
            ->get();
    }

    public function findById($id)
    {
        $data = User::find($id);
        if (!$data) {
            throw new APIException(404, "user not found!");
        }
        return $data;
    }

    public function create($data)
    {
        $user = User::create([
            'hash_code' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'password' => bcrypt($data['password']),
            'is_enabled_2fa' => false,
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

        if ($user->status === 1) {
            return 1;
        }

        $user->status = 1;
        $user->email_verified_at = Carbon::now();
        $user->save();
        return 0;
    }

    public function enable2FA($hash)
    {
        $user = $this->findByHash($hash);

        if ($user->is_enabled_2fa) {
            return false;
        } else {
            $user->is_enabled_2fa = true;
            $user->save();
        }
        return true;
    }

    public function findByEmail($email)
    {
        $user =  User::where('email', $email)->first();
        if (!$user) {
            throw new APIException(404, "user not found!");
        }

        return $user;
    }
}
