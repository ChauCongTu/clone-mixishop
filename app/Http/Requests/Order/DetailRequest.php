<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            'order_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'size' => '',
            'color' => '',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'total' => 'required|numeric'
        ];
    }
}
