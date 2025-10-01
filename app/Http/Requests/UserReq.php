<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'password' => 'required|min:10',
            'email' => 'required|unique:users,email,',
        ];
    }

    public function messages()
    {
        return [
            'required'      => ':attribute không được để trống',
            'exists'        => ':attribute không tồn tại',
            'numeric'       => ':attribute phải là số',
            'max'           => ':attribute tối đa',
            'min'           => ':attribute tối thiểu',
            "unique"        => ':attribute đã tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'name'   => 'tên người dùng',
            'password'      => 'mật khẩu',
            'email'      => 'Email',
        ];
    }
}
