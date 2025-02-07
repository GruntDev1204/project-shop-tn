<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Exceptions\AuthorizeException;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function returnJson($data, $code, $mesage)
    {
        return response()->json([
            'status' => $code,
            'message' => $mesage,
            'data' => $data
        ], $code);
    }

    protected function getAuth()
    {
        $user = auth()->user();
        $this->checkIsBlocked($user->email);
        if (!$user) {
            throw new AuthException('User not authenticated.');
        }

        $roleUser = RoleUser::where('user_id', $user->id)->first();
        if (!$roleUser) {
            throw new AuthException('User does not have a valid role.');
        }

        $role = Role::find($roleUser->role_id);
        if (!$role) {
            throw new APIException(404, 'Role not found.');
        }

        $user->role = $role->name;

        return $user;
    }

    protected function authorizeRole($role)
    {
        $user = $this->getAuth();
        if ($user->role !== $role) {
            throw new AuthorizeException("You do not have permission to perform this action!");
        }
    }

    protected function checkIsBlocked($email)
    {
        $user = User::where('email', $email)->first();
        if (!in_array($user->status, [0, 1])) {
            throw new AuthorizeException("bạn bị cho cook khỏi server!");
        }
    }
}
