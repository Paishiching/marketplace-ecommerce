<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'sometimes|integer|exists:products,id',
            'customer_id' => 'sometimes|integer|exists:customers,id',
            'order_item_id' => 'sometimes|integer|exists:order_items,id',
            'comment' => 'sometimes|string',
            'status' => 'sometimes|string|in:pending,approved,rejected',
        ];
    }
}
