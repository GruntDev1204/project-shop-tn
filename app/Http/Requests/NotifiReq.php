<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotifiReq extends FormRequest
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
            'title'   => 'required|min:20|max:100',
            'is_anonymous' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'is_anonymous|required' => 'Hãy chọn chế độ cho bài đăng!',
            'content.min' => 'Nội dung tối thiểu 100 kí tự',
            'content.exists' => 'Nội dung tối đa 1000 kí tự',
            'title.min' => 'Tiêu đề tối thiểu 20 kí tự',
            'title.exists' => 'Tiêu đề tối đa 100 kí tự',
        ];
    }
}
