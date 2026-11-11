<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'order_number' => 'required|string|max:50|unique:orders,order_number',
            'order_status_id' => 'nullable|integer|exists:order_status,id',
            'subtotal' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'shipping_amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'coupon_id' => 'nullable|integer|exists:coupons,id',
            'shipping_address_id' => 'nullable|integer|exists:shipping_address,id',
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled,refunded',
        ];
    }
}
