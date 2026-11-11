<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResellerEarningController extends Controller
{
    public function index(Request $request)
    {
        $rows = DB::table('reseller_orders as o')
            ->join('resellers as r', 'r.id', '=', 'o.reseller_id')
            ->leftJoin('reseller_products as rp', 'rp.id', '=', 'o.reseller_product_id')
            ->leftJoin('products as p', 'p.id', '=', 'rp.product_id')
            ->where('o.status', '!=', 'cancelled')
            ->when($request->filled('from'), fn ($q) => $q->whereDate('o.created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('o.created_at', '<=', $request->to))
            ->groupBy('o.reseller_id', 'r.business_name')
            ->selectRaw('o.reseller_id,
                r.business_name,
                COUNT(o.id) as orders,
                SUM(o.quantity) as units,
                SUM(o.total_price) as revenue,
                SUM(o.quantity * COALESCE(p.price, 0)) as cost,
                SUM(o.total_price - o.quantity * COALESCE(p.price, 0)) as earning')
            ->orderByDesc('earning')
            ->get();

        $totals = [
            'orders'  => $rows->sum('orders'),
            'revenue' => $rows->sum('revenue'),
            'cost'    => $rows->sum('cost'),
            'earning' => $rows->sum('earning'),
        ];

        return view('superadmin.resellers.earnings.index', compact('rows', 'totals'));
    }
}
