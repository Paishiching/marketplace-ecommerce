<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\SupplierOrder;
use Illuminate\Http\Request;

class SupplierOrderController extends Controller
{
    public function index()
    {
        $supplierOrders = SupplierOrder::latest()->paginate(20);

        return view('admin.orders.index', compact('supplierOrders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for SupplierOrder
        ]);

        $supplierOrder = SupplierOrder::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'SupplierOrder created successfully.');
    }

    public function show(SupplierOrder $supplierOrder)
    {
        return view('admin.orders.show', compact('supplierOrder'));
    }

    public function edit(SupplierOrder $supplierOrder)
    {
        return view('admin.orders.edit', compact('supplierOrder'));
    }

    public function update(Request $request, SupplierOrder $supplierOrder)
    {
        $validated = $request->validate([
            // TODO: add validation rules for SupplierOrder
        ]);

        $supplierOrder->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'SupplierOrder updated successfully.');
    }

    public function destroy(SupplierOrder $supplierOrder)
    {
        $supplierOrder->delete();

        return redirect()->route('admin.orders.index')->with('success', 'SupplierOrder deleted successfully.');
    }
}
