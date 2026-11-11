<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'order_item_id' => 'nullable|integer|exists:order_items,id',
            'comment' => 'nullable|string',
            'status' => 'required|string|in:pending,approved,rejected',
        ];
    }
}
