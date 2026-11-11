<?php

namespace App\Services\Couriers;

use App\Models\Order;
use App\Models\Shipment;

interface CourierDriver
{
    /**
     * Parcel book kore. Return: ['consignment_id' => ?string, 'tracking_number' => ?string, 'status' => string]
     */
    public function book(Order $order, float $cod, ?string $note, array $input = []): array;

    /** Courier er current status. API na thakle null. */
    public function status(Shipment $shipment): ?string;
}