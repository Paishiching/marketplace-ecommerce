<?php

namespace App\Http\Controllers\Wholesale;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use App\Models\WholesaleProduct;
use App\Models\WholesaleTier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $partner = $request->user()->wholesaler;
        abort_unless($partner && $partner->status === 'approved', 403);

        $productIds = WholesaleProduct::where('wholesaler_id', $partner->id)->select('id');
        $salesValue = BulkOrder::where('wholesaler_id', $partner->id)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->sum('total_price');
        $stats = [
            ['label' => 'Bulk products', 'value' => WholesaleProduct::where('wholesaler_id', $partner->id)->count(), 'icon' => 'bx-package'],
            ['label' => 'Bulk orders', 'value' => BulkOrder::where('wholesaler_id', $partner->id)->count(), 'icon' => 'bx-receipt'],
            ['label' => 'Price tiers', 'value' => WholesaleTier::whereIn('wholesale_product_id', $productIds)->count(), 'icon' => 'bx-purchase-tag-alt'],
            ['label' => 'Sales value', 'value' => 'BDT ' . number_format((float) $salesValue, 2), 'icon' => 'bx-line-chart'],
        ];

        return view('wholesale.dashboard.index', compact('partner', 'stats'));
    }
}

