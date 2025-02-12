<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UserReq;
use App\Mail\ActiveUser;
use App\Models\User;
use App\Service\extend\IServiceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $userSV;

    public function __construct(IServiceUser $userSV)
    {
        $this->userSV = $userSV;
    }

    public function viewActive($hash_code)
    {
        $user = User::where('hash_code', $hash_code)->first();
        if (!$user) {
            throw new APIException(404, "user by this hash not found!");
        }

        $userName = $user->name;
        $email = $user->email;
        $avatar = $user->avatar;
        $hash_code = $user->hash_code;

        return view('active.active', compact('userName', 'email', 'hash_code', 'avatar'));
    }

    public function signup(UserReq $request)
    {
        $data = $request->all();
        $user = $this->userSV->create($data);

        return $this->returnJson($user, 201, "resigter success!");
    }

    public function updateProfile(UpdateUser $request)
    {
        $user = $this->getAuth();
        $data = $request->all();
        $dataUpdate = $this->userSV->update($user->id, $data);

        return $this->returnJson($dataUpdate, 200, "update successful!");
    }

    public function getAll()
    {
        $this->authorizeRole('CEO');
        $data = $this->userSV->getAll();
        if (!$data || empty($data)) {
            throw new APIException(500, "failure!");
        }

        return $this->returnJson($data, 200, "success!");
    }

    public function sendMail()
    {
        $user = $this->getAuth();

        $isAdmin = in_array($user->role, ['Admin', 'CEO']);
        if ($isAdmin) {
            $this->userSV->activeUser($user->hash_code);

            return $this->returnJson([
                'role' => $user->role
            ], 200, "you don't need to activate users because you are an admin!");
        } else {
            if ($user->status === 1) {
                return $this->returnJson(null, 202, "your account is already active!");
            }

            $record = $this->generateOtp($user->email, $user->hash_code, 'active');

            Mail::to($user->email)->send(new ActiveUser($user->name, $user->hash_code,  $record['otp'], 'Active User'));
            return $this->returnJson($user->role, 202, "email sent successfully , please check your email address and continue!");
        }
    }

    public function changeRole($id, Request $rq)
    {
        $this->authorizeRole('CEO');
        $roleName = $this->validateField($rq->role, 'role');

        $role = $this->userSV->changeRole($id, $roleName);
        return $this->returnJson($role, 200, "changed role successfully!");
    }

    public function changeStatus($id, Request $req)
    {
        $this->authorizeRole('CEO');
        $status = $this->validateField($req->status, 'status');

        $this->userSV->changeStatus($id, $status);

        return $this->returnJson($status, 200, "changed status successfully!");
    }

    public function activeUsers($hash_code, Request $req)
    {
        $otp = $req->otp;
        if (!$otp) {
            throw new APIException(422, "OTP is required!");
        }
        $this->verifyOTP($hash_code, $otp, null ,  'active');
        $status = $this->userSV->activeUser($hash_code);

        DB::table('manager_tokens')->where('token', $hash_code)->where('type', 'active')->delete();
        if ($status === 1) {
            return $this->returnJson(null, 201, "your account is already active!");
        }

        return $this->returnJson(null, 200, "active user successfully!");
    }
}
