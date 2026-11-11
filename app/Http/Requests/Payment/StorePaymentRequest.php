<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method_id' => 'nullable|integer|exists:payment_methods,id',
            'amount' => 'required|numeric',
            'transaction_ref' => 'nullable|string|max:150',
            'status' => 'required|string|in:pending,paid,failed,refunded',
            'paid_at' => 'nullable|date',
        ];
    }
}
