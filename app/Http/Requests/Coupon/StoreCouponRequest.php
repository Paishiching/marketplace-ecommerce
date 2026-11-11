<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|string|in:fixed,percent',
            'value' => 'required|numeric',
            'min_order_amount' => 'required|numeric',
            'usage_limit' => 'nullable|integer',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
