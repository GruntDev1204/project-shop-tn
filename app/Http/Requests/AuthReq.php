<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthReq extends FormRequest
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
            'password'   => 'required',
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
            'email'   => 'email',
            'password' => 'password',
            'role' => 'role',
        ];
    }
}
