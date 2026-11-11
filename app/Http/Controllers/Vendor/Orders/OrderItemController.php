<?php

namespace App\Http\Controllers\Vendor\Orders;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::latest()->paginate(20);

        return view('vendor.orders.index', compact('orderItems'));
    }

    public function create()
    {
        return view('vendor.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for OrderItem
        ]);

        $orderItem = OrderItem::create($validated);

        return redirect()->route('vendor.orders.index')->with('success', 'OrderItem created successfully.');
    }

    public function show(OrderItem $orderItem)
    {
        return view('vendor.orders.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        return view('vendor.orders.edit', compact('orderItem'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            // TODO: add validation rules for OrderItem
        ]);

        $orderItem->update($validated);

        return redirect()->route('vendor.orders.index')->with('success', 'OrderItem updated successfully.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()->route('vendor.orders.index')->with('success', 'OrderItem deleted successfully.');
    }
}
