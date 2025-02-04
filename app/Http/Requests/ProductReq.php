<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductReq extends FormRequest
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
            'name'   => 'required|max:100',
            'price'   => 'required|numeric|min:1000',
            'category_id'   => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'required'      => ':attribute không được để trống',
            'exists'        => ':attribute không tồn tại',
            'numeric'       => ':attribute phải là số',
            'max'           => ':attribute tối đa',
        ];
    }

    public function attributes()
    {
        return [
            'name'   => 'Tên Sản phẩm',
            'price'      => 'Gía bán',
            'category_id'      => 'Danh mục',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 422,
                'message' => 'Data request not valid!',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
