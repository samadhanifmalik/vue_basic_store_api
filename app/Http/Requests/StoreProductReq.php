<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'string|nullable',
            'sku' => 'string|nullable',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'minimum_qty' => 'integer|min:1',
            'stock_qty' => 'integer|nullable',
            'photo' => 'nullable'
        ];
    }
}
