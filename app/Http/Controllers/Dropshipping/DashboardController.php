<?php

namespace App\Http\Controllers\Dropshipping;

use App\Http\Controllers\Controller;
use App\Models\DropshipperOrder;
use App\Models\DropshipperProduct;
use App\Models\Dropshipper;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $partner = $request->user()->dropshipper;
        abort_unless($partner && $partner->status === 'approved', 403);

        $paidOut = Withdrawal::where('withdrawable_type', Dropshipper::class)
            ->where('withdrawable_id', $partner->id)
            ->where('status', 'paid')
            ->sum('amount');
        $stats = [
            ['label' => 'Active products', 'value' => DropshipperProduct::where('dropshipper_id', $partner->id)->where('is_active', true)->count(), 'icon' => 'bx-package'],
            ['label' => 'Dropship orders', 'value' => DropshipperOrder::where('dropshipper_id', $partner->id)->count(), 'icon' => 'bx-receipt'],
            ['label' => 'Net profit', 'value' => 'BDT ' . number_format((float) DropshipperOrder::where('dropshipper_id', $partner->id)->sum('profit'), 2), 'icon' => 'bx-line-chart'],
            ['label' => 'Paid out', 'value' => 'BDT ' . number_format((float) $paidOut, 2), 'icon' => 'bx-wallet'],
        ];

        return view('dropshipping.dashboard.index', compact('partner', 'stats'));
    }
}

