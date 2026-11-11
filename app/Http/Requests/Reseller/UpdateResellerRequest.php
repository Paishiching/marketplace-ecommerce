<?php

namespace App\Http\Requests\Reseller;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer|exists:users,id',
            'business_name' => 'sometimes|string|max:150',
            'markup_rate' => 'sometimes|numeric',
            'status' => 'sometimes|string|in:active,inactive,suspended',
        ];
    }
}
