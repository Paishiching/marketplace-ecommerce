<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropshippingProfitController extends Controller
{
    public function index(Request $request)
    {
        $rows = DB::table('dropshipping_order_items as i')
            ->join('dropshipping_orders as o', 'o.id', '=', 'i.dropshipping_order_id')
            ->leftJoin('dropshipping_products as p', function ($join) {
                $join->on('p.vendor_id', '=', 'o.vendor_id')
                    ->on('p.supplier_product_id', '=', 'i.supplier_product_id');
            })
            ->leftJoin('vendors as v', 'v.id', '=', 'o.vendor_id')
            ->where('o.status', '!=', 'cancelled')
            ->when($request->filled('from'), fn ($q) => $q->whereDate('o.created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('o.created_at', '<=', $request->to))
            ->groupBy('o.vendor_id', 'v.shop_name', 'v.name')
            ->selectRaw('o.vendor_id,
                COALESCE(v.shop_name, v.name) as vendor_name,
                COUNT(DISTINCT o.id) as orders,
                SUM(i.quantity) as units,
                SUM(i.quantity * i.unit_cost) as cost,
                SUM(i.quantity * COALESCE(p.markup_price, 0)) as profit')
            ->orderByDesc('profit')
            ->get();

        $totals = [
            'orders' => $rows->sum('orders'),
            'units'  => $rows->sum('units'),
            'cost'   => $rows->sum('cost'),
            'profit' => $rows->sum('profit'),
        ];

        return view('superadmin.dropshipping.profit.index', compact('rows', 'totals'));
    }
}
