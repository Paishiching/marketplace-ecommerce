<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => 'sometimes|integer|exists:parents,id',
            'name' => 'sometimes|string|max:150',
            'slug' => 'sometimes|string|max:150',
            'image' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:active,inactive',
        ];
    }
}
