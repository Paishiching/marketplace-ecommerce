<?php

namespace App\Http\Controllers\Vendor\Finance;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Support\VendorWallet;

class BalanceController extends Controller
{
    public function index()
    {
        $vendor  = $this->vendor();
        $wallet  = VendorWallet::summary($vendor);
        $minimum = VendorWallet::MIN_WITHDRAWAL;

        return view('vendor.balance.index', compact('wallet', 'minimum'));
    }

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }
}