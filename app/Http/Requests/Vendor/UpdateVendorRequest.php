<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer|exists:users,id',
            'shop_name' => 'sometimes|string|max:150',
            'shop_slug' => 'sometimes|string|max:150',
            'logo' => 'sometimes|string|max:255',
            'banner' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'commission_rate' => 'sometimes|numeric',
            'verification_status' => 'sometimes|string|in:pending,verified,rejected',
            'status' => 'sometimes|string|in:active,inactive,suspended',
        ];
    }
}
