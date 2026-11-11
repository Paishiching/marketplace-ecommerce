<?php

namespace App\Http\Requests\Reseller;

use Illuminate\Foundation\Http\FormRequest;

class StoreResellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'business_name' => 'nullable|string|max:150',
            'markup_rate' => 'required|numeric',
            'status' => 'required|string|in:active,inactive,suspended',
        ];
    }
}
