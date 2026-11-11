<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Dropshipper;

class DropshipperAccountController extends PartnerController
{
    protected function cfg(): array
    {
        return ['model' => Dropshipper::class, 'role' => 'dropshipping', 'title' => 'Dropshipping Partners', 'prefix' => 'superadmin.dropshipper-accounts', 'name' => 'business_name', 'rate' => null, 'rate_label' => null, 'verify' => false];
    }
}
