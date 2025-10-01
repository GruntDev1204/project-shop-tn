<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostReq extends FormRequest
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
            'content'   => 'required|min:100|max:1000',
            'media'   => 'max:300',
        ];
    }

    public function messages()
    {
        return [
            'content.min' => 'Nội dung tối thiểu 100 kí tự',
            'content.max' => 'Nội dung tối đa 1000 kí tự',
            'media.max' => 'file nguon qua dai',
            'content.required' => 'Vui long nhập nội dung bài đăng',
        ];
    }
}
