<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiStoreOrderRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
        ];
    }
}
