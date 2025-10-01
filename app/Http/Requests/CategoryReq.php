<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CategoryReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'required'      => ':attribute không được để trống',
        ];
    }

    public function attributes()
    {
        return [
            'name'   => 'Tên Danh Mục',
        ];
    }
}
