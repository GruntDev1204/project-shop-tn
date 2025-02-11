<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReq;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\UpdateAuthReq;
use App\Mail\RequestForgotPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


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

    private function generateOtp($email)
    {
        $token = Str::uuid();
        $otp = random_int(100000, 999999);
        $hashedOtp = bcrypt($otp);

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'otp_token' => $hashedOtp,
            'created_at' => Carbon::now()
        ]);

        return [
            'otp' => $otp,
            'token' => $token
        ];
    }

    private function findReqSecurity($email = null, $token = null)
    {
        if ($email !== null) {
            $resetRecord = DB::table('password_reset_tokens')
                ->where('email', $email)
                ->first();
        } else if ($token !== null) {
            $resetRecord = DB::table('password_reset_tokens')
                ->where('token', $token)
                ->first();
        } else {
            throw new APIException(422, "Token or email is required!");
        }

        if (!$resetRecord) {
            throw new APIException(404, "Reset request not found!");
        }

        return $resetRecord;
    }

    private function verifyOTP($token, $otp, $email)
    {
        $resetRecord = $this->findReqSecurity($email, null);
        if ($resetRecord->token !== $token) {
            throw new APIException(422, "Invalid or expired reset link!");
        }

        if (!Hash::check($otp, $resetRecord->otp_token)) {
            // DB::table('password_reset_tokens')->where('email', $email)->delete();
            throw new APIException(422, "Invalid OTP! Please try again.");
        }

        return $resetRecord;
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

    public function reqForgotPasswordForm(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return $this->returnJson(null, 422, "token is required");
        }

        $resetRecord = $this->findReqSecurity(null, $token);
        $user = User::where('email', $resetRecord->email)->first();

        if (!$user) {
            throw new APIException(404, "user by this email not found!");
        }

        return view('security.reset_password_form', compact('token', 'user'));
    }

    public function requestForgotPassword(Request $request)
    {
        $email = $request->email;

        $this->validateField($email, 'email');
        $this->checkIsBlocked($email);
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new APIException(404, "user by this email not found!");
        }

        $data = $this->generateOtp($email);

        Mail::to($email)->send(new RequestForgotPassword($email, $data['token'], $data['otp']));
        return $this->returnJson(null, 202, "email to reset your password sent  successfully!");
    }

    public function resetPassword(ResetPassword $request)
    {
        $this->checkIsBlocked($request->email);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw new APIException(404, "user by this email not found!");
        }
        $this->verifyOTP($request->query('token'), $request->otp, $request->email);
        $user->password = bcrypt($request->new_password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
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

        $this->validateCredentials($authReq->only('email', 'password'));

        $ps = User::find($user->id);
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
        return $this->respondWithToken(auth()->refresh());
    }
}
