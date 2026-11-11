<?php

namespace App\Http\Controllers\Vendor\Finance;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorOrder;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function index(Request $request)
    {
        $vendor = $this->vendor();

        $base = fn () => VendorOrder::query()
            ->where('vendor_id', $vendor->id)
            ->whereHas('order', fn ($q) => $q->whereNull('deleted_at'))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->input('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->input('to')));

        // Cancelled / returned order er taka earning e dhora hobe na
        $valid = fn () => $base()->whereHas('order', fn ($q) => $q->whereNotIn('status', ['cancelled', 'returned']));

        $totalSales      = (float) $valid()->sum('subtotal');
        $totalCommission = (float) $valid()->sum('commission_amount');
        $netEarning      = $totalSales - $totalCommission;

        $earnings = $base()
            ->with('order:id,order_number,name,status,payment_status,created_at')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('vendor.earnings.index', compact('earnings', 'totalSales', 'totalCommission', 'netEarning'));
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