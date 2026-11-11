<?php

namespace App\Http\Requests\Wholesale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWholesaleProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'sometimes|integer|exists:vendors,id',
            'product_id' => 'sometimes|integer|exists:products,id',
            'status' => 'sometimes|string|in:active,inactive',
        ];
    }
}
