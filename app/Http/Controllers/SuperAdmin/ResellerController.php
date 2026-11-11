<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Reseller;

class ResellerController extends PartnerController
{
    protected function cfg(): array
    {
        return [
            'model'  => Reseller::class,
            'role'   => 'reseller',
            'title'  => 'Resellers',
            'prefix' => 'superadmin.resellers',
            'name'   => 'business_name',
            'rate'   => 'markup_rate',
            'rate_label' => 'Markup %',
            'verify' => false,
        ];
    }
}