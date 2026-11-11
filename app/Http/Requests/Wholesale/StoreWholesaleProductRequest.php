<?php

namespace App\Http\Requests\Wholesale;

use Illuminate\Foundation\Http\FormRequest;

class StoreWholesaleProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'required|integer|exists:vendors,id',
            'product_id' => 'required|integer|exists:products,id',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
