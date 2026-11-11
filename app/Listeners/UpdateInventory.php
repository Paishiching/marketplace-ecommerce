<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Events\OrderCancelled;
use App\Models\Inventory;
use App\Models\StockMovement;

class UpdateInventory
{
    /**
     * Deduct stock for each ordered item when an order is placed,
     * and restore it if the order is later cancelled.
     */
    public function handleOrderPlaced(OrderPlaced $event): void
    {
        foreach ($event->order->orderItems as $item) {
            $this->adjustStock($item->product_id, -$item->quantity, 'sale', $item->order_id);
        }
    }

    public function handleOrderCancelled(OrderCancelled $event): void
    {
        foreach ($event->order->orderItems as $item) {
            $this->adjustStock($item->product_id, $item->quantity, 'cancellation', $item->order_id);
        }
    }

    protected function adjustStock(int $productId, int $quantityChange, string $reason, int $orderId): void
    {
        $inventory = Inventory::firstOrCreate(['product_id' => $productId], ['quantity' => 0]);
        $inventory->increment('quantity', $quantityChange);

        StockMovement::create([
            'product_id' => $productId,
            'quantity' => $quantityChange,
            'reason' => $reason,
            'reference_id' => $orderId,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe($events): array
    {
        return [
            OrderPlaced::class => 'handleOrderPlaced',
            OrderCancelled::class => 'handleOrderCancelled',
        ];
    }
}
