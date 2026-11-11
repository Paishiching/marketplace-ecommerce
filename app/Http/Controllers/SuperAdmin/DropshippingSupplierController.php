<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class DropshippingSupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount(['supplierProducts', 'dropshippingOrders'])
            ->withSum('dropshippingOrders', 'total_cost')
            ->latest()
            ->paginate(15);

        return view('superadmin.dropshipping.suppliers.index', compact('suppliers'));
    }
}
