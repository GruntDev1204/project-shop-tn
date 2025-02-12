<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Exceptions\AuthorizeException;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function findReqSecurity($email = null, $token = null ,  $type)
    {
        if ($email !== null) {
            $resetRecord = DB::table('manager_tokens')
                ->where('email', $email)->where('type' , $type)
                ->first();
        } else if ($token !== null) {
            $resetRecord = DB::table('manager_tokens')
                ->where('token', $token)->where('type' , $type)
                ->first();
        } else {
            throw new APIException(422, "Token or email is required!");
        }

        if (!$resetRecord) {
            throw new APIException(404, "Reset request not found or expired!");
        }

        return $resetRecord;
    }

    protected function verifyOTP($token, $otp, $email = null , $type)
    {
        if($email === null) {
            $resetRecord = $this->findReqSecurity(null, $token , $type);
        }else{
            $resetRecord = $this->findReqSecurity($email, null , $type);
        }

        if ($email !== null && $resetRecord->token !== $token) {
            throw new APIException(422, "Invalid or expired link!");
        }

        if (!Hash::check($otp, $resetRecord->otp_token)) {
            throw new APIException(422, "Invalid OTP! Please try again.");
        }

        if (Carbon::now()->greaterThan($resetRecord->expires_at)) {
            DB::table('manager_tokens')->where('email', $email)->delete();
            throw new APIException(410, "The OTP has expired. Please request a new one.");
        }

        return $resetRecord;
    }

    protected function generateOtp($email, $token = null , $type)
    {
        if ($token === null) {
            $token = Str::uuid();
        }
        $otp = random_int(100000, 999999);
        $hashedOtp = bcrypt($otp);

        DB::table('manager_tokens')->where('email', $email)->where('type', $type)->delete();
        DB::table('manager_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'otp_token' => $hashedOtp,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

        return [
            'otp' => $otp,
            'token' => $token
        ];
    }

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
        if (!$user) {
            throw new AuthException('User not authenticated, please login and try again!');
        }

        $this->checkIsBlocked($user->email);
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
            throw new AuthorizeException("You do not have permission to perform this action! required role: " . $role);
        }
    }

    protected function checkIsBlocked($email)
    {
        $user = User::where('email', $email)->first();
        if (!in_array($user->status, [0, 1])) {
            throw new AuthorizeException("bạn bị cho cook khỏi server!");
        }
    }

    protected function checkRoleName($roleName, $email)
    {
        $user = User::where('email', $email)->first();
        $roleUser = RoleUser::where('user_id', $user->id)->first();
        if (!$roleUser) {
            throw new AuthException('User does not have a valid role.');
        }

        $role = Role::find($roleUser->role_id);
        if (!$role) {
            throw new APIException(404, 'Role not found.');
        }

        if ($roleName === 'Admin' && $role->name === 'Customer') {
            throw new AuthorizeException("You do not have permission to perform this action!");
        }

        return $role->name;
    }

    protected function validateField($col, $colName)
    {
        if (!$col) {
            throw new APIException(400, $colName . " is required!");
        }
        return $col;
    }
}
