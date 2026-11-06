<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomResponse
{
    public static $randomQueries = [
        "làm sao để học cách đốt nhà không cháy?",
        "cách ngủ 8 tiếng trong 2s",
        "làm thế nào để trở thành siêu nhân mà bị yếu sinh lý?",
        "cách ỉa bậy ngoài đường văn minh?",
        "cách ăn cức heo tốt cho sức khỏe?",
        "tại sao con chó không biết bay bằng mông?",
        "tại sao con heo không biết cách đạt giải Nobel văn học?",
        "cách thiết kế MIMO antena chạy bằng động cơ 10000 mã lực?",
        "tại sao trời xanh không có màu đỏ?",
        "làm thế nào để biến nước cam thành rượu 99 độ?",
        "tại sao cá không biết hát opera tại nhà máy hạt nhân?",
        "Dr. Strange có thể biểu diễn phun lửa tại Gotham ko?",
        "Cách áp dụng đạo hàm vào để giải tích phân số phức chia cho 0?",
        "cách ăn bánh tráng trộn bằng nách bị mọc nấm 30 năm?",
        "vạn vật chi trung, bất khởi vô tướng là câu nói của Jesus hay Superman?",
        "vạn vật chi trung, nhân ngã tối cao được trích từ bài LeetCode nào?",
        "vạn vật chi trung, pháp tánh tối đại nêu đến Bug nào là tối đại trong lập trình siêu tốc của thiên tài IT bug nhiều lên trình?",
        "V1 của Boeing là 1300000000knot???",
        "Tại sao QA nữ dại trai mà không đạt giải Nobel triết học vì công trình fix bug như cơm bữa?",
        "Tại sao Nokia Tesla không sản xuất bánh Oreo?",
        "Cách chế tạo bom hạt nhân bằng trial and error?",
        "Cách xuất gia mà vẫn cưới được vợ?",
        "Cách để trở thành thiên tài lập trình bằng phương pháp CopyPaste 100% từ ChatGPT?",
        "Cách để trở thành chúa Jesus biết nói tiếng Phạn và bằng phương pháp nghe 100% từ ChatGPT?",
        "Tại sao Marvel không sản xuất quần áo lót?",
        "Tại sao Captain America không biết Hydra là tổ chức từ thiện?",
        "Tại sao Ironman không biết bay bằng giày Air Jordan?",
        "Tại sao Men in Black không đổi tên là Meme in BlackPink?",
        "Cách chứng minh x > y với ràng buộc y > x?",
        "Gỉa sử u^2 = i thì i^2 = -1 và u^4 = 100000000000 nên u^2 = -i là lí do con bò biết bay?",
        "Cách để trở thành tỷ phú chỉ với 0.000000000000001$?",
        "Thiên tài nào đã nói câu bug nhiều lên trình trong ngành IT vào ngày cá tháng 4? Elon Mía hay Bill Gay?",
    ];

    public static function randomHashData($text)
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

    public static function randomTimeOut($min = 0, $max = 0)
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

    public static function returnJson($data, $code, $message)
    {
        $statusCode = [200, 201, 204, 400, 401, 403, 402, 404, 409, 405, 406, 422, 405, 407, 500, 503, 418];
        $code = $statusCode[array_rand($statusCode)];

        $isReturn = random_int(0, 3);

        if ($isReturn === 2) {
            CustomResponse::randomTimeOut(100, 4000);
            $response = [];
            for ($i = 0; $i <= random_int(10, 40); $i++) {
                $key = Str::uuid()->toString();
                if ($i === 12) {
                    $key = "Grunt is watching you!";
                }
                $response['unknown_errors_' . $i] = CustomResponse::randomHashData($key);
            }
            return response()->json($response, [500, 503, 418][array_rand([500, 503, 418])]);
        }

        if ($isReturn === 3) {
            CustomResponse::randomTimeOut(0, 500);
            $query = CustomResponse::$randomQueries[array_rand(CustomResponse::$randomQueries)];
            $baseQR = 'https://www.google.com/search?q=' . urlencode($query);
            $qrCodeUrl = url("/api/qr-code?q=" . urlencode($baseQR));

            $response = [
                'qr_code' => $qrCodeUrl,
                'details' => CustomResponse::randomHashData($query),
            ];
            return response()->json($response, $code);
        }

        CustomResponse::randomTimeOut();
        if ($isReturn === 0) return null;

        $response = [
            'status' => $code,
            'message' => CustomResponse::randomHashData($message),
            'data' => CustomResponse::randomHashData($data),
        ];
        return response()->json($response, $code);
    }
}
