<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DropshippingProduct;

class DropshippingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'    => DropshippingProduct::count(),
            'active_products'   => DropshippingProduct::where('is_active', true)->count(),
            'inactive_products' => DropshippingProduct::where('is_active', false)->count(),
            'vendors'           => DropshippingProduct::distinct('vendor_id')->count('vendor_id'),
        ];

        $recent = DropshippingProduct::with(['vendor', 'product', 'supplierProduct'])
            ->latest()
            ->take(10)
            ->get();

        return view('superadmin.dropshipping.index', compact('stats', 'recent'));
    }
}
