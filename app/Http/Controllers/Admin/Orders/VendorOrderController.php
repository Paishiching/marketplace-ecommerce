<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\VendorOrder;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function index()
    {
        $vendorOrders = VendorOrder::latest()->paginate(20);

        return view('admin.orders.index', compact('vendorOrders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for VendorOrder
        ]);

        $vendorOrder = VendorOrder::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'VendorOrder created successfully.');
    }

    public function show(VendorOrder $vendorOrder)
    {
        return view('admin.orders.show', compact('vendorOrder'));
    }

    public function edit(VendorOrder $vendorOrder)
    {
        return view('admin.orders.edit', compact('vendorOrder'));
    }

    public function update(Request $request, VendorOrder $vendorOrder)
    {
        $validated = $request->validate([
            // TODO: add validation rules for VendorOrder
        ]);

        $vendorOrder->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'VendorOrder updated successfully.');
    }

    public function destroy(VendorOrder $vendorOrder)
    {
        $vendorOrder->delete();

        return redirect()->route('admin.orders.index')->with('success', 'VendorOrder deleted successfully.');
    }
}
