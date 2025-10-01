<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_ids'   => 'required|array|min:1',
            'cart_ids.*' => 'integer|exists:carts,id',
        ];
    }

    public function messages()
    {
        return [
            'cart_ids.required' => 'Bạn chưa chọn giỏ hàng nào!',
            'cart_ids.array'    => 'Dữ liệu giỏ hàng không hợp lệ!',
            'cart_ids.*.exists' => 'Một hoặc nhiều giỏ hàng không tồn tại hoặc đã bị xóa!',
        ];
    }

    public function attributes()
    {
        return [
            'cart_ids'   => 'Danh sách giỏ hàng',
        ];
    }
}
