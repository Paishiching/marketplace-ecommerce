<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|integer|exists:parents,id',
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:categories,slug',
            'image' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
