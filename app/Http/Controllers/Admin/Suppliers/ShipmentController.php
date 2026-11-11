<?php

namespace App\Http\Controllers\Admin\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::latest()->paginate(20);

        return view('admin.suppliers.index', compact('shipments'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment = Shipment::create($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Shipment created successfully.');
    }

    public function show(Shipment $shipment)
    {
        return view('admin.suppliers.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('admin.suppliers.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment->update($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Shipment deleted successfully.');
    }
}
