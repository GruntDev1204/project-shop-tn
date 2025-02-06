<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReq;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_at' => Carbon::now()->addHours(24)->toDateTimeString()
        ];
        return $this->returnJson($data, 200, null);
    }

    public function login(AuthReq $authReq)
    {
        $credentials = $authReq->only('email', 'password');
        if (! $token = auth()->attempt($credentials)) {
            throw new AuthException("login failed");
        }
        return $this->respondWithToken($token);
    }

    public function resetPassword(AuthReq $authReq)
    {
        $user = $this->getAuth();
        $ps = User::find($user->id);
        $ps->password =  bcrypt($authReq->password);
        $ps->save();

        $this->logout();
        return $this->returnJson($user, 200, "your password has been reset!");
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
