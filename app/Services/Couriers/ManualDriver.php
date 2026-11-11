<?php

namespace App\Services\Couriers;

use App\Models\Order;
use App\Models\Shipment;
use RuntimeException;

class ManualDriver implements CourierDriver
{
    public function book(Order $order, float $cod, ?string $note, array $input = []): array
    {
        $tracking = trim((string) ($input['tracking_number'] ?? ''));

        if ($tracking === '') {
            throw new RuntimeException('Tracking / booking number is required for this courier.');
        }

        return [
            'consignment_id'  => null,
            'tracking_number' => $tracking,
            'status'          => 'booked',
        ];
    }

    public function status(Shipment $shipment): ?string
    {
        return null;
    }
}