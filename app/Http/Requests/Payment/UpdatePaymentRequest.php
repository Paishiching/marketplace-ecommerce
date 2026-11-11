<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'sometimes|integer|exists:orders,id',
            'payment_method_id' => 'sometimes|integer|exists:payment_methods,id',
            'amount' => 'sometimes|numeric',
            'transaction_ref' => 'sometimes|string|max:150',
            'status' => 'sometimes|string|in:pending,paid,failed,refunded',
            'paid_at' => 'sometimes|date',
        ];
    }
}
