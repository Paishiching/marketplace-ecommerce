<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Wholesaler;

class WholesalerAccountController extends PartnerController
{
    protected function cfg(): array
    {
        return ['model' => Wholesaler::class, 'role' => 'wholesale', 'title' => 'Wholesale Partners', 'prefix' => 'superadmin.wholesaler-accounts', 'name' => 'business_name', 'rate' => null, 'rate_label' => null, 'verify' => false];
    }
}
