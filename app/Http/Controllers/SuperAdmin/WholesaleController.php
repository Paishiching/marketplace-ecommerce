<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\WholesaleProduct;

class WholesaleController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'    => WholesaleProduct::count(),
            'enabled_products'  => WholesaleProduct::where('is_wholesale_enabled', true)->count(),
            'disabled_products' => WholesaleProduct::where('is_wholesale_enabled', false)->count(),
        ];

        $recent = WholesaleProduct::with('product')
            ->latest()
            ->take(10)
            ->get();

        return view('superadmin.wholesale.index', compact('stats', 'recent'));
    }
}
