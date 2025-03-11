<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Exceptions\AuthorizeException;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Service\extend\IServiceUser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $userSV;

    public function __construct(IServiceUser $userSV)
    {
        $this->userSV = $userSV;
    }

    private function getUserRole($userId)
    {
        $roleUser = RoleUser::where('user_id', $userId)->first();
        if (!$roleUser) {
            throw new AuthException('User does not have a valid role.');
        }

        $role = Role::find($roleUser->role_id);
        if (!$role) {
            throw new APIException(404, 'Role not found.');
        }

        return $role->name;
    }

    protected function getDataPaginate($dataPage)
    {
        return [
            'page' => $dataPage->currentPage(),
            'page_size' => $dataPage->perPage(),
            'total_items' => $dataPage->total(),
            'total_pages' => $dataPage->lastPage(),
            'items' => $dataPage->items(),
        ];
    }

    protected function returnJson($data, $code, $message)
    {
        $response = [
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }

    protected function checkIsBlocked($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new APIException(404, "User does not exist!");
        }
        if (!in_array($user->status, [0, 1])) {
            throw new AuthorizeException("bạn bị cho cook khỏi server!");
        }
    }

    protected function generateOtp($email, $token, $type)
    {
        $otp = random_int(100000, 999999);
        $hashedOtp = bcrypt($otp);
        $token_id = bcrypt($token);

        DB::table('manager_tokens')->where('token', $token)->where('type', $type)->delete();
        DB::table('manager_tokens')->insert([
            'token_id' => $token_id,
            'email' => $email,
            'token' => $token,
            'otp_token' => $hashedOtp,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

        return [
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(5),
            'otp' => $otp,
            'token' => $token,
        ];
    }

    protected function findReqSecurity($token,  $type)
    {
        $resetRecord = DB::table('manager_tokens')
            ->where('token', $token)->where('type', $type)
            ->first();

        if (!$resetRecord) {
            throw new APIException(404, "Request not found or expired!");
        }

        if (!Hash::check($token, $resetRecord->token_id)) {
            throw new APIException(401, "Invalid request! Please try again.");
        }

        $expiredTime  = Carbon::parse($resetRecord->expires_at)->addMinutes(2);
        if (Carbon::now()->greaterThan($expiredTime)) {
            $this->deleteOTP($resetRecord->token, $resetRecord->type);
            throw new APIException(410, "The OTP has expired. Please request a new one.");
        }

        return $resetRecord;
    }

    protected function verifyOTP($token, $otp, $type)
    {
        $resetRecord = $this->findReqSecurity($token, $type);

        if (!Hash::check($otp, $resetRecord->otp_token)) {
            throw new APIException(401, "Invalid OTP! Please try again.");
        }

        return $resetRecord;
    }

    protected function deleteOTP($token, $type)
    {
        $rs = $this->findReqSecurity($token, $type);
        DB::table('manager_tokens')->where('token', $rs->token)->where('type', $rs->type)->delete();
    }

    protected function getAuth()
    {
        $user = auth()->user();
        if (!$user) {
            throw new AuthException('User not authenticated, please login and try again!');
        }

        $this->checkIsBlocked($user->email);
        $role = $this->getUserRole($user->id);
        $user->role = $role;

        return $user;
    }

    protected function hasRole(string|array $role)
    {
        $userRole = $this->getAuth()->role;

        if (is_array($role)) {
            return in_array($userRole, $role);
        }

        return $userRole === $role;
    }

    protected function authorizeRole(string|array $roles)
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        throw new AuthorizeException("You do not have permission! Required roles: " . implode(', ', $roles));
    }

    protected function validateRoleName($roleName, $email)
    {
        $user = User::where('email', $email)->first();
        $role = $this->getUserRole($user->id);

        if ($roleName === 'Admin' && $role === 'Customer') {
            throw new AuthorizeException("You do not have permission to perform this action!");
        }

        return $role;
    }

    protected function validateField($col, $colName)
    {
        if (!$col) {
            throw new APIException(400, $colName . " is required!");
        }
        return $col;
    }
}
