<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth2FAREq;
use App\Http\Requests\AuthReq;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\UpdateAuthReq;
use App\Mail\RequestForgotPassword;
use App\Mail\RequestLogin2FA;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private function verifyCredentials($credentials)
    {
        $this->checkIsBlocked($credentials['email']);
        if (!auth()->validate($credentials)) {
            throw new AuthException("login failed! email or password is incorrect!");
        }
        return true;
    }

    private function generateAuthToken($credentials)
    {
        $this->verifyCredentials($credentials);
        return auth()->attempt($credentials);
    }

    private function respondWithToken($role, $token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_at' => Carbon::now()->addHours(12)->toDateTimeString(),
            'role' => $role
        ];
        return $this->returnJson($data, 200, null);
    }

    public function login(AuthReq $authReq)
    {
        $role = $authReq->role;
        $credentials = $authReq->only('email', 'password');
        $token = $this->generateAuthToken($credentials);

        $user = $this->userSV->findByEmail($authReq->email);
        if ($user->is_enabled_2fa) {

            $otp = $this->generateOtp($user->email, $user->hash_code, 'login');
            $user->remember_token = $token;
            $user->save();

            Mail::to($user->email)->queue(new RequestLogin2FA($user->name, $otp['expires_at'], $otp['otp']));
            return $this->returnJson(null, 202, "email sent successfully , please check your email address and continue!");
        } else {
            return $this->respondWithToken($this->validateRoleName($role, $authReq->email), $token);
        }
    }

    public function login2FA(Auth2FAREq $request)
    {
        $user = $this->userSV->findByEmail($request->email);
        $this->verifyOTP($user->hash_code, $request->otp, 'login');

        $token = $user->remember_token;
        if (!$token) {
            throw new APIException(401, "Invalid or expired token!");
        }

        $user->remember_token = null;
        $user->save();
        $this->deleteOTP($user->hash_code, 'login');

        return $this->respondWithToken($this->validateRoleName($request->role, $request->email), $token);
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

    public function forgotPasswordForm(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return $this->returnJson(null, 422, "token is required");
        }

        $resetRecord = $this->findReqSecurity($token, 'repassword');
        $expire_time = $resetRecord->expires_at;
        $user = $this->userSV->findByEmail($resetRecord->email);

        return view('security.reset_password_form', compact('token', 'user', 'expire_time'));
    }

    public function requestForgotPassword(Request $request)
    {
        $email = $request->email;

        $this->validateField($email, 'email');
        $this->checkIsBlocked($email);
        $user = $this->userSV->findByEmail($email);
        if (!$user) {
            throw new APIException(404, "user by this email not found!");
        }

        $otpData = $this->generateOtp($email, $user->hash_code, 'repassword');

        Mail::to($email)->queue(new RequestForgotPassword($user->name, $otpData['created_at'], $otpData['expires_at'], $otpData['token'], $otpData['otp']));
        return $this->returnJson(null, 202, "email to reset your password sent  successfully!");
    }

    public function resetPassword(ResetPassword $request)
    {
        $this->checkIsBlocked($request->email);
        $user = $this->userSV->findByEmail($request->email);
        if (!$user) {
            throw new APIException(404, "user by this email not found!");
        }
        $this->verifyOTP($request->query('token'), $request->otp, 'repassword');
        $user->password = bcrypt($request->new_password);
        $user->save();

        $this->deleteOTP($request->query('token'), 'repassword');
        return $this->returnJson(null, 201, "your password has been reset! please re-login");
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

        $this->verifyCredentials($authReq->only('email', 'password'));

        $ps = $this->userSV->findById($user->id);
        $ps->password =  bcrypt($authReq->new_password);
        $ps->save();
        $this->logout();
        return $this->returnJson(null, 201, "your password has been reset! please re-login");
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
        return $this->respondWithToken('Admin', auth()->refresh());
    }
}
