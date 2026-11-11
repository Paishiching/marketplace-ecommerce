<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'withdrawal_method_id' => 'nullable|integer|exists:withdrawal_methods,id',
            'amount' => 'required|numeric',
            'account_details' => 'nullable|string',
            'status' => 'required|string|in:pending,approved,rejected,paid',
        ];
    }
}
