<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiUpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_no' => 'sometimes|required|string',
            'store_id' => 'sometimes|required|integer',
            'customer_name' => 'sometimes|required|string',
            'status' => 'sometimes|in:pending,completed',
            'items' => 'sometimes|array|min:1',
            'items.*.product_name' => 'sometimes|required|string',
            'items.*.qty' => 'sometimes|required|integer|min:1',
        ];
    }
}
