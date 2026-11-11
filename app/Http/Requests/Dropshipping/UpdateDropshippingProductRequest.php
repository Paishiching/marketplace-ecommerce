<?php

namespace App\Http\Requests\Dropshipping;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDropshippingProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'sometimes|integer|exists:vendors,id',
            'supplier_product_id' => 'sometimes|integer|exists:supplier_products,id',
            'selling_price' => 'sometimes|numeric',
            'status' => 'sometimes|string|in:active,inactive',
        ];
    }
}
