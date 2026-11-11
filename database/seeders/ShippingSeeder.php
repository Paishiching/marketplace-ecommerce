<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use App\Models\ShippingRate;
use App\Models\Courier;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        $couriers = [
            ['name' => 'Standard Courier', 'code' => 'standard'],
            ['name' => 'Express Courier', 'code' => 'express'],
        ];

        foreach ($couriers as $courier) {
            Courier::firstOrCreate(['code' => $courier['code']], $courier);
        }

        $zones = [
            'Inside Dhaka' => 60,
            'Outside Dhaka' => 120,
        ];

        foreach ($zones as $zoneName => $baseRate) {
            $zone = ShippingZone::firstOrCreate(['name' => $zoneName]);

            ShippingRate::firstOrCreate(
                ['shipping_zone_id' => $zone->id, 'courier_id' => Courier::where('code', 'standard')->first()->id],
                ['rate' => $baseRate]
            );

            ShippingRate::firstOrCreate(
                ['shipping_zone_id' => $zone->id, 'courier_id' => Courier::where('code', 'express')->first()->id],
                ['rate' => $baseRate * 1.5]
            );
        }
    }
}
