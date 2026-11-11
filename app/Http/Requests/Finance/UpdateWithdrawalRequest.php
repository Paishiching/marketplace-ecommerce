<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer|exists:users,id',
            'withdrawal_method_id' => 'sometimes|integer|exists:withdrawal_methods,id',
            'amount' => 'sometimes|numeric',
            'account_details' => 'sometimes|string',
            'status' => 'sometimes|string|in:pending,approved,rejected,paid',
        ];
    }
}
