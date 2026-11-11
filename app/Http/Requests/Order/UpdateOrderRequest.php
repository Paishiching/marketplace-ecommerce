<?php

namespace App\Http\Requests\Order;

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
            'customer_id' => 'sometimes|integer|exists:customers,id',
            'order_number' => 'sometimes|string|max:50',
            'order_status_id' => 'sometimes|integer|exists:order_status,id',
            'subtotal' => 'sometimes|numeric',
            'discount_amount' => 'sometimes|numeric',
            'shipping_amount' => 'sometimes|numeric',
            'total_amount' => 'sometimes|numeric',
            'coupon_id' => 'sometimes|integer|exists:coupons,id',
            'shipping_address_id' => 'sometimes|integer|exists:shipping_address,id',
            'status' => 'sometimes|string|in:pending,processing,shipped,delivered,cancelled,refunded',
        ];
    }
}
