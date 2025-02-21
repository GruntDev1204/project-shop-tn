<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Auth2FAREq extends FormRequest
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
            'otp'   => 'required',
            'email'   => 'required|exists:users,email',
            'role' => 'required|exists:roles,name',
        ];
    }

    public function messages()
    {
        return [
            'required'      => ':attribute không được để trống',
            'exists' => ':attribute không tồn tại',
        ];
    }


    public function attributes()
    {
        return [
            'otp'   => 'otp',
            'email'   => 'email',
            'role' => 'role',
        ];
    }
}
