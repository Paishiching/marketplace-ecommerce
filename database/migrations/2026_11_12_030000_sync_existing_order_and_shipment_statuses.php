<?php

use App\Support\DeliveryOrderStatusSync;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // The latest shipment is the delivery status customers should see.
        DB::table('shipments')->select(['id', 'order_id', 'status'])
            ->orderBy('id')
            ->chunkById(500, function ($shipments) {
                foreach ($shipments as $shipment) {
                    $orderStatus = DeliveryOrderStatusSync::orderStatusForShipment($shipment->status);
                    if ($orderStatus) {
                        DB::table('orders')->where('id', $shipment->order_id)->update(['status' => $orderStatus]);
                    }
                }
            });
    }

    public function down(): void
    {
        // Status values may have been changed by staff after this sync ran.
    }
};
