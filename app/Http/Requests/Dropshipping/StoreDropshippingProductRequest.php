<?php

namespace App\Http\Requests\Dropshipping;

use Illuminate\Foundation\Http\FormRequest;

class StoreDropshippingProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'required|integer|exists:vendors,id',
            'supplier_product_id' => 'required|integer|exists:supplier_products,id',
            'selling_price' => 'required|numeric',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
