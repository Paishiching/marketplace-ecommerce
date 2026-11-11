<?php

namespace Database\Seeders;

use App\Models\CommissionRule;
use Illuminate\Database\Seeder;

class CommissionRuleSeeder extends Seeder
{
    public function run(): void
    {
        // A global default rule (vendor_id = null) plus a couple of
        // category-level examples. Vendor-specific rules can override
        // these later by inserting a row with that vendor_id.
        CommissionRule::firstOrCreate(
            ['vendor_id' => null, 'category_id' => null],
            ['rate' => 10, 'type' => 'percentage', 'status' => 'active']
        );

        CommissionRule::firstOrCreate(
            ['vendor_id' => null, 'category_id' => null, 'channel' => 'affiliate'],
            ['rate' => 5, 'type' => 'percentage', 'status' => 'active']
        );

        CommissionRule::firstOrCreate(
            ['vendor_id' => null, 'category_id' => null, 'channel' => 'dropshipping'],
            ['rate' => 15, 'type' => 'percentage', 'status' => 'active']
        );
    }
}
