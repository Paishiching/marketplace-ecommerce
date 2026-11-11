<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function index(Request $request)
    {
        $statuses = BulkOrder::query()->distinct()->pluck('status');

        $orders = BulkOrder::with('wholesaleProduct.product')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalRevenue = BulkOrder::sum('total_price');

        return view('superadmin.wholesale.bulk-orders.index', compact('orders', 'statuses', 'totalRevenue'));
    }
}
