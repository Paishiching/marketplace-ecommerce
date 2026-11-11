<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'shop_name' => 'required|string|max:150',
            'shop_slug' => 'required|string|max:150|unique:vendors,shop_slug',
            'logo' => 'nullable|string|max:255',
            'banner' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'commission_rate' => 'required|numeric',
            'verification_status' => 'required|string|in:pending,verified,rejected',
            'status' => 'required|string|in:active,inactive,suspended',
        ];
    }
}
