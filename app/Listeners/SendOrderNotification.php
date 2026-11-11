<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Events\OrderPaid;
use App\Events\OrderShipped;
use App\Events\OrderDelivered;
use App\Events\OrderCancelled;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\OrderConfirmedNotification;
use App\Notifications\OrderShippedNotification;
use App\Notifications\OrderDeliveredNotification;

class SendOrderNotification
{
    public function handleOrderPlaced(OrderPlaced $event): void
    {
        $event->order->customer?->notify(new OrderPlacedNotification($event->order));
    }

    public function handleOrderPaid(OrderPaid $event): void
    {
        $event->order->customer?->notify(new OrderConfirmedNotification($event->order));
    }

    public function handleOrderShipped(OrderShipped $event): void
    {
        $event->order->customer?->notify(new OrderShippedNotification($event->order));
    }

    public function handleOrderDelivered(OrderDelivered $event): void
    {
        $event->order->customer?->notify(new OrderDeliveredNotification($event->order));
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe($events): array
    {
        return [
            OrderPlaced::class => 'handleOrderPlaced',
            OrderPaid::class => 'handleOrderPaid',
            OrderShipped::class => 'handleOrderShipped',
            OrderDelivered::class => 'handleOrderDelivered',
        ];
    }
}
