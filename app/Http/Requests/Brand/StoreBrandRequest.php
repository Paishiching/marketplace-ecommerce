<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:brands,slug',
            'logo' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
