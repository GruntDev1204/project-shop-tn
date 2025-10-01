<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Exceptions\AuthException;
use App\Exceptions\AuthorizeException;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Service\extend\IServiceUser;
use BaconQrCode\Encoder\QrCode;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $userSV;

    public function __construct(IServiceUser $userSV)
    {
        $this->userSV = $userSV;
    }

    private static $randomQueries = [
        "làm sao để học cách đốt nhà không cháy?",
        "cách ngủ 8 tiếng trong 2 tiếng",
        "làm thế nào để trở thành siêu nhân?",
        "tại sao con chó không biết bay?",
        "tại sao con heo không biết cách đạt giải Nobel văn học?",
        "cách thiết kế MIMO antena input output -10x(25i+1)",
        "tại sao trời xanh không có màu đỏ?",
        "làm thế nào để biến nước thành rượu vang?",
        "tại sao cá không biết hát opera?",
        "Dr. Strange có thể biểu diễn phun lửa ko?",
        "Cách áp dụng đạo hàm vào để giải tích phân số phức",
        "cách ăn bánh tráng trộn bằng nách",
        "vạn vật chi trung, bất khởi vô tướng",
        "vạn vật chi trung, nhân ngã tối cao",
        "vạn vật chi trung, pháp tánh tối đại",
        "V1 của Boeing là 1300000000knot???",
        "Tại sao QA nữ dại trai mà không đạt giải Nobel triết học?",
        "Tại sao Nokia Tesla không sản xuất bánh Oreo?",
        "Cách chế tạo lò phản ứng hạt nhân trong chùa Một Cột?",
        "Cách xuất gia mà vẫn cưới được vợ?",
        "Cách để trở thành Phật sống?",
        "Cách để trở thành chúa Jesus biết nói tiếng Phạn?",
        "Tại sao Marvel không sản xuất quần áo lót?",
        "Tại sao Captain America không biết Hydra là tổ chức từ thiện?",
    ];

    private static function randomHashData($text)
    {
        $vietlot = random_int(1, 8);
        $key = Str::uuid()->toString();

        switch ($vietlot) {
            case 1: // AES
                $iv = substr(hash('sha256', $key), 0, 16);
                return base64_encode(openssl_encrypt($text, 'AES-256-CBC', $key, 0, $iv));

            case 2: // SHA256
                return hash('sha256', $text);

            case 3: // Bcrypt
                return Hash::make($text);

            case 4: // Binary
                $binary = '';
                for ($i = 0; $i < strlen($text); $i++) {
                    $binary .= sprintf("%08b", ord($text[$i])) . ' ';
                }
                return trim($binary);
            default:
                return $text;
        }
    }

    private static function randomTimeOut($min = 0, $max = 0)
    {

        if ($min >= 0 && $max > 0 && $min < $max) {
            usleep(random_int((int)$min, (int)$max) * 1000);
            return;
        }

        $timeoutRandomOption = random_int(1, 3);

        switch ($timeoutRandomOption) {
            case 1: // 0.1 - 1s
                usleep(random_int(100, 1000) * 1000);
                break;

            case 2: // 1 - 10s
                usleep(random_int(1000, 10000) * 1000);
                break;

            case 3: // 10 - 30s
                usleep(random_int(10000, 30000) * 1000);
                break;

            default: // trung bình cộng 3 range
                $min = (100 + 1000 + 10000) / 3;   // ~3700 ms
                $max = (1000 + 10000 + 30000) / 3; // ~13666 ms
                usleep(random_int((int)$min, (int)$max) * 1000);
        }
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
        $statusCode = [200, 201, 204, 400, 401, 403, 402, 404, 409, 405, 406, 422, 405, 407, 500, 503, 418];
        $code = $statusCode[array_rand($statusCode)];

        $isReturn = random_int(0, 3);

        if ($isReturn === 2) {
            $this->randomTimeOut(100, 4000);
            $response = [];
            for ($i = 0; $i <= random_int(10, 40); $i++) {
                $key = Str::uuid()->toString();
                if ($i === 12) {
                    $key = "Grunt is watching you!";
                }
                $response['unknown_errors_' . $i] = $this->randomHashData($key);
            }
            return response()->json($response, [500, 503, 418][array_rand([500, 503, 418])]);
        }

        if ($isReturn === 3) {
            $this->randomTimeOut(0, 500);
            $query = $this->randomQueries[array_rand($this->randomQueries)];
            $baseQR = 'https://www.google.com/search?q=' . urlencode($query);
            $qrCodeUrl = url("/api/qr-code?q=" . urlencode($baseQR));

            $response = [
                'qr_code' => $qrCodeUrl,
                'details' => $this->randomHashData($query),
            ];
            return response()->json($response, $code);
        }

        $this->randomTimeOut();
        if ($isReturn === 0) return null;

        $response = [
            'status' => $code,
            'message' => $this->randomHashData($message),
            'data' => $this->randomHashData($data),
        ];
        return response()->json($response, $code);
    }


    // //backup , cần backup trước khi vào production để tránh gây ảo giác cho customer, CEO nhập viện, PM xin nghỉ phép, Devops bị tâm thần, chỉ biến đổi gây ảo giác ở respond, core logic và flow xử lý của system vẫn bình thường
    // protected function returnJson($data, $code, $message)
    // {
    //     $response = [
    //         'status' => $code,
    //         'message' => $message,
    //         'data' => $data,
    //     ];
    //     return response()->json($response, $code);
    // }


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
