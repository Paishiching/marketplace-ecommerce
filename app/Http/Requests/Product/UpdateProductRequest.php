<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'sometimes|integer|exists:vendors,id',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'brand_id' => 'sometimes|integer|exists:brands,id',
            'name' => 'sometimes|string|max:200',
            'slug' => 'sometimes|string|max:200',
            'sku' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'discount_price' => 'sometimes|numeric',
            'product_type' => 'sometimes|string|in:own,dropshipping,wholesale,reseller',
            'thumbnail' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:draft,pending,published,rejected',
        ];
    }
}
