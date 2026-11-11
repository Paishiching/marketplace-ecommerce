<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|string|max:150|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|max:255',
            'role_id' => 'nullable|integer|exists:roles,id',
            'user_type' => 'required|string|in:superadmin,admin,vendor,supplier,affiliate,reseller,customer',
            'avatar' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive,banned',
            'remember_token' => 'nullable|string|max:100',
        ];
    }
}
