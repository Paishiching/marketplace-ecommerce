<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipping_address_id' => 'required|integer|exists:shipping_addresses,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'coupon_code' => 'nullable|string|max:50',
            'note' => 'nullable|string',
        ];
    }
}
