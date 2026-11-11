<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer|exists:users,id',
            'company_name' => 'sometimes|string|max:150',
            'company_slug' => 'sometimes|string|max:150',
            'logo' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'verification_status' => 'sometimes|string|in:pending,verified,rejected',
            'status' => 'sometimes|string|in:active,inactive,suspended',
        ];
    }
}
