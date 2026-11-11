<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:150',
            'slug' => 'sometimes|string|max:150',
            'logo' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:active,inactive',
        ];
    }
}
