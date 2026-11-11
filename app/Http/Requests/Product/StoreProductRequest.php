<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'nullable|integer|exists:vendors,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:products,slug',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'product_type' => 'required|string|in:own,dropshipping,wholesale,reseller',
            'thumbnail' => 'nullable|string|max:255',
            'status' => 'required|string|in:draft,pending,published,rejected',
        ];
    }
}
