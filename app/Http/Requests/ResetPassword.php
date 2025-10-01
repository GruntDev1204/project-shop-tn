<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest
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
            'email'   => 'required|exists:users,email',
            'otp'   => 'required',
            'token' => 'required',
            'new_password' => 'required|min:10',
        ];
    }

    public function messages()
    {
        return [
            'required'      => ':attribute không được để trống',
            'exists' => ':attribute không tồn tại',
            'min' => ':attribute phải ít nhất là 10 ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'email'   => 'email',
            'otp' => 'otp',
            'token' => 'token',
            'new_password' => 'new password',
        ];
    }
}
