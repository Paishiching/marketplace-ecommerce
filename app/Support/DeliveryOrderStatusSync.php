<?php

namespace App\Support;

use App\Models\Order;
use App\Models\Shipment;

class DeliveryOrderStatusSync
{
    public static function syncFromShipment(Shipment $shipment): void
    {
        $orderStatus = self::orderStatusForShipment($shipment->status);

        if (! $orderStatus) return;

        $order = Order::find($shipment->order_id);
        if ($order && $order->status !== $orderStatus) {
            $order->forceFill(['status' => $orderStatus])->saveQuietly();
        }

        Shipment::where('order_id', $shipment->order_id)
            ->whereKeyNot($shipment->id)
            ->get()
            ->each(function (Shipment $other) use ($shipment) {
                if ($other->status !== $shipment->status) {
                    $other->forceFill(['status' => $shipment->status])->saveQuietly();
                }
            });
    }

    public static function orderStatusForShipment(?string $status): ?string
    {
        return match ($status) {
            'pending' => 'pending',
            'processing' => 'processing',
            'out_for_delivery', 'in_transit' => 'shipped',
            'completed', 'complete' => 'completed',
            'delivered' => 'delivered',
            'cancelled', 'cancel' => 'cancelled',
            'returned' => 'returned',
            default => null,
        };
    }

    public static function syncFromOrder(Order $order): void
    {
        $shipmentStatus = self::shipmentStatusForOrder($order->status);

        if (! $shipmentStatus) return;

        $order->shipments()->get()->each(function (Shipment $shipment) use ($shipmentStatus) {
            if ($shipment->status !== $shipmentStatus) {
                $shipment->forceFill(['status' => $shipmentStatus])->saveQuietly();
            }
        });
    }

    public static function shipmentStatusForOrder(?string $status): ?string
    {
        return match ($status) {
            'pending' => 'pending',
            'processing' => 'processing',
            'shipped' => 'out_for_delivery',
            'completed', 'delivered' => 'completed',
            'cancelled' => 'cancelled',
            'returned' => 'returned',
            default => null,
        };
    }
}
