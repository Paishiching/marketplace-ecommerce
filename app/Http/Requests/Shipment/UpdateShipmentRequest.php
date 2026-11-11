<?php

namespace App\Http\Requests\Shipment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'sometimes|integer|exists:orders,id',
            'courier_id' => 'sometimes|integer|exists:couriers,id',
            'tracking_number' => 'sometimes|string|max:150',
            'status' => 'sometimes|string|in:pending,in_transit,delivered,returned',
            'shipped_at' => 'sometimes|date',
            'delivered_at' => 'sometimes|date',
        ];
    }
}
