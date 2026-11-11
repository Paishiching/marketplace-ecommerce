<?php

namespace App\Http\Controllers\Supplier\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);

        return view('supplier.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('supplier.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Order
        ]);

        $order = Order::create($validated);

        return redirect()->route('supplier.orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        return view('supplier.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('supplier.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Order
        ]);

        $order->update($validated);

        return redirect()->route('supplier.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('supplier.orders.index')->with('success', 'Order deleted successfully.');
    }
}
