<?php

namespace App\Http\Controllers\Supplier\Orders;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::latest()->paginate(20);

        return view('supplier.orders.index', compact('shipments'));
    }

    public function create()
    {
        return view('supplier.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment = Shipment::create($validated);

        return redirect()->route('supplier.orders.index')->with('success', 'Shipment created successfully.');
    }

    public function show(Shipment $shipment)
    {
        return view('supplier.orders.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('supplier.orders.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment->update($validated);

        return redirect()->route('supplier.orders.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('supplier.orders.index')->with('success', 'Shipment deleted successfully.');
    }
}
