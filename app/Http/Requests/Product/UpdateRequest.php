<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'product_code' => 'required',
            'name' => 'required|min:3',
            'summary' => 'required|min:5',
            'desc' => '',
            'total_quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
        ];
    }
}
