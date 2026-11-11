<?php

namespace App\Http\Requests\Affiliate;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffiliateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'referral_code' => 'required|string|max:50|unique:affiliates,referral_code',
            'commission_rate' => 'required|numeric',
            'status' => 'required|string|in:active,inactive,suspended',
        ];
    }
}
