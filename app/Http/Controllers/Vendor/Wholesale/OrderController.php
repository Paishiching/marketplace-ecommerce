<?php

namespace App\Http\Controllers\Vendor\Wholesale;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);

        return view('vendor.wholesale.index', compact('orders'));
    }

    public function create()
    {
        return view('vendor.wholesale.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Order
        ]);

        $order = Order::create($validated);

        return redirect()->route('vendor.wholesale.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        return view('vendor.wholesale.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('vendor.wholesale.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Order
        ]);

        $order->update($validated);

        return redirect()->route('vendor.wholesale.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('vendor.wholesale.index')->with('success', 'Order deleted successfully.');
    }
}
