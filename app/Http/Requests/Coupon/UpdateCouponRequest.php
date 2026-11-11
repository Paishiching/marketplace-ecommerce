<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'sometimes|string|max:50',
            'type' => 'sometimes|string|in:fixed,percent',
            'value' => 'sometimes|numeric',
            'min_order_amount' => 'sometimes|numeric',
            'usage_limit' => 'sometimes|integer',
            'starts_at' => 'sometimes|date',
            'expires_at' => 'sometimes|date',
            'status' => 'sometimes|string|in:active,inactive',
        ];
    }
}
