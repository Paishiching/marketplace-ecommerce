<?php

namespace App\Jobs;

use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Events\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncCourierShipment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $backoff = 120;

    public function __construct(protected Shipment $shipment)
    {
    }

    /**
     * Poll the courier's tracking API for status updates on this
     * shipment and log any new tracking events. Firing OrderShipped
     * the first time a "shipped"/"in_transit" status is seen.
     */
    public function handle(): void
    {
        // Placeholder for the actual courier API call. Replace this
        // with a real HTTP client call to the courier's tracking endpoint.
        $latestStatus = $this->shipment->status;

        TrackingEvent::create([
            'shipment_id' => $this->shipment->id,
            'status' => $latestStatus,
            'occurred_at' => now(),
        ]);

        if ($latestStatus === 'in_transit') {
            event(new OrderShipped($this->shipment->order));
        }
    }
}
