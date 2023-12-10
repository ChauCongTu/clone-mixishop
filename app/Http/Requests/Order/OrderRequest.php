<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|numeric',
            'total' => 'required|numeric',
            'final_total' => 'required|numeric',
            'payment_method' => 'required',
            'payment_status' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'post_code' => 'required',
            'address' => 'required',
            'ward' => 'required',
            'district' => 'required',
            'city' => 'required'
        ];
    }
}
