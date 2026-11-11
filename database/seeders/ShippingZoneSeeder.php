<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use App\Models\ShippingRate;
use Illuminate\Database\Seeder;

class ShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        $dhaka = ShippingZone::create([
            'name'    => 'Dhaka',
            'regions' => ['Dhaka'],
            'status'  => true,
        ]);

        ShippingRate::create([
            'shipping_zone_id' => $dhaka->id,
            'name'  => 'Inside Dhaka',
            'rate'  => 70,
        ]);

        $others = ShippingZone::create([
            'name'    => 'Outside Dhaka',
            'regions' => ['OTHERS'],
            'status'  => true,
        ]);

        ShippingRate::create([
            'shipping_zone_id' => $others->id,
            'name'  => 'Outside Dhaka',
            'rate'  => 170,
        ]);
    }
}
