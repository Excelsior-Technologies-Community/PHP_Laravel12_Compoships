<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_no' => 'required|string',
            'store_id' => 'required|integer',
            'customer_name' => 'required|string',
            'status' => 'sometimes|in:pending,completed',
            'product_name' => 'sometimes|array|min:1',
            'product_name.*' => 'sometimes|required|string',
            'qty' => 'sometimes|array|min:1',
            'qty.*' => 'sometimes|required|integer|min:1',
        ];
    }
}
