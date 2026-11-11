<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $supplier = $user->supplier;
        $stats = [
            ['label' => 'Products', 'value' => $supplier->supplierProducts()->count()],
            ['label' => 'Pending products', 'value' => $supplier->supplierProducts()->where('status', 'pending')->count()],
            ['label' => 'Orders', 'value' => (Schema::hasTable('supplier_orders') ? $supplier->supplierOrders()->count() : 0) + $supplier->dropshippingOrders()->count()],
        ];

        return view('supplier.dashboard.index', compact('user', 'supplier', 'stats'));
    }
}
