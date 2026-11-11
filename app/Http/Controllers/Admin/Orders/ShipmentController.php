<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('order')->latest()->paginate(20);

        return view('admin.orders.shipments.index', compact('shipments'));
    }

    public function create()
    {
        $orders = Order::with('customer.user')->whereIn('status', ['pending', 'processing'])->whereDoesntHave('shipments')->latest()->get();

        return view('admin.orders.shipments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'driver_name' => ['required', 'string', 'max:150'],
            'driver_phone' => ['required', 'string', 'max:30'],
            'vehicle_number' => ['required', 'string', 'max:50'],
            'vehicle_owner' => ['required', 'string', 'max:150'],
            'expected_arrival_at' => ['required', 'date', 'after_or_equal:today'],
        ]);

        DB::transaction(function () use ($validated) {
            $order = Order::whereKey($validated['order_id'])->whereIn('status', ['pending', 'processing'])->lockForUpdate()->first();
            abort_unless($order && ! $order->shipments()->exists(), 422, 'This order already has transport details or is not ready for delivery.');

            Shipment::create([
                ...$validated,
                'transport_type' => 'self',
                'tracking_number' => 'SELF-' . now()->format('ymd') . '-' . Str::upper((string) Str::uuid()),
                'status' => 'pending',
            ]);
        });

        $indexRoute = $request->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.index' : 'admin.orders.shipments.index';

        return redirect()->route($indexRoute)->with('success', 'Delivery transport saved successfully.');
    }

    public function show(Shipment $shipment)
    {
        return view('admin.orders.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('admin.orders.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Shipment deleted successfully.');
    }
}
