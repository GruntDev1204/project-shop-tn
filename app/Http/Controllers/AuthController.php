<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReq;
use App\Models\User;

class AuthController extends Controller
{
    public function login(AuthReq $authReq)
    {
        $credentials = $authReq->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
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
            return $this->returnJson(true, 200, "your authentication is OK!");
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if ($this->getAuth()) {
            auth()->logout();
            return response()->json([], 204);
        }
    }

    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600
        ];
        return $this->returnJson($data, 200, null);
    }
}
