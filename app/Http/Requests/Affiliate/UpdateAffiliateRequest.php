<?php

namespace App\Http\Requests\Affiliate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAffiliateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer|exists:users,id',
            'referral_code' => 'sometimes|string|max:50',
            'commission_rate' => 'sometimes|numeric',
            'status' => 'sometimes|string|in:active,inactive,suspended',
        ];
    }
}
