<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:150',
            'email' => 'sometimes|string|max:150',
            'phone' => 'sometimes|string|max:30',
            'email_verified_at' => 'sometimes|date',
            'password' => 'sometimes|string|max:255',
            'role_id' => 'sometimes|integer|exists:roles,id',
            'user_type' => 'sometimes|string|in:superadmin,admin,vendor,supplier,affiliate,reseller,customer',
            'avatar' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:active,inactive,banned',
            'remember_token' => 'sometimes|string|max:100',
        ];
    }
}
