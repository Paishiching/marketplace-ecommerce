<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::latest()->paginate(20);

        return view('admin.orders.index', compact('orderItems'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for OrderItem
        ]);

        $orderItem = OrderItem::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'OrderItem created successfully.');
    }

    public function show(OrderItem $orderItem)
    {
        return view('admin.orders.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        return view('admin.orders.edit', compact('orderItem'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            // TODO: add validation rules for OrderItem
        ]);

        $orderItem->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'OrderItem updated successfully.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()->route('admin.orders.index')->with('success', 'OrderItem deleted successfully.');
    }
}
