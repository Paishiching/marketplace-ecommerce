<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'company_name' => 'required|string|max:150',
            'company_slug' => 'required|string|max:150|unique:suppliers,company_slug',
            'logo' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'verification_status' => 'required|string|in:pending,verified,rejected',
            'status' => 'required|string|in:active,inactive,suspended',
        ];
    }
}
