<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReq;
use App\Http\Requests\UpdateAuthReq;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    private function validateCredentials($credentials)
    {
        if (!auth()->validate($credentials)) {
            throw new AuthException("verify failed! your password is incorrect!");
        }
    }

    private function verifyLogin($credentials)
    {
        $this->checkIsBlocked($credentials['email']);
        $this->validateCredentials($credentials);
        $token = auth()->attempt($credentials);
        return $token;
    }

    private function respondWithToken($role, $token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_at' => Carbon::now()->addHours(24)->toDateTimeString(),
            'role' => $role
        ];
        return $this->returnJson($data, 200, null);
    }

    public function login(AuthReq $authReq)
    {
        $role = $authReq->role;

        $credentials = $authReq->only('email', 'password');
        $token = $this->verifyLogin($credentials);

        return $this->respondWithToken($this->checkRoleName($role, $authReq->email), $token);
    }

    public function changePassword(UpdateAuthReq $authReq)
    {
        $user = $this->getAuth();

        if ($user->email !== $authReq->email) {
            throw new APIException(422, "email not match!");
        }

        if ($authReq->password === $authReq->new_password) {
            return $this->returnJson(null, 202, "your new password is the same as your old password! you don't have to change it!");
        }

        $this->validateCredentials($authReq->only('email', 'password'));

        $ps = User::find($user->id);
        $ps->password =  bcrypt($authReq->new_password);
        $ps->save();
        $this->logout();
        return $this->returnJson(null, 201, "your password has been reset! please re-login");
    }

    public function profile()
    {
        return $this->returnJson($this->getAuth(), 200, null);
    }

    public function checkAuth()
    {
        if ($this->getAuth()) {
            $expirationTime = Carbon::parse(auth()->getPayload()->get('exp'));

            $info = [
                "expires_at" => $expirationTime->toDateTimeString(),
                "role" => $this->getAuth()->role
            ];
            return $this->returnJson($info, 200, "your authentication is OK!");
        }
    }

    public function logout()
    {
        if ($this->getAuth()) {
            auth()->logout();
            return response()->json([], 204);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
