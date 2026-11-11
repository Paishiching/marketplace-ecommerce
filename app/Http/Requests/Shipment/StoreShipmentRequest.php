<?php

namespace App\Http\Requests\Shipment;

use Illuminate\Foundation\Http\FormRequest;

class StoreShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'courier_id' => 'nullable|integer|exists:couriers,id',
            'tracking_number' => 'nullable|string|max:150',
            'status' => 'required|string|in:pending,in_transit,delivered,returned',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ];
    }
}
