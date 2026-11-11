<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index(Request $request)
    {
        $query = ShippingZone::withCount('shippingRates')->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $zones = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => ShippingZone::count(),
            'active'   => ShippingZone::where('status', true)->count(),
            'inactive' => ShippingZone::where('status', false)->count(),
        ];

        return view('superadmin.shipping-zones.index', compact('zones', 'stats'));
    }

    public function create()
    {
        $zone = new ShippingZone();

        return view('superadmin.shipping-zones.create', compact('zone'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100|unique:shipping_zones,name',
            'regions' => 'nullable|string', // comma-separated input, converted below
            'status'  => 'boolean',
        ]);

        $validated['regions'] = $validated['regions']
            ? array_map('trim', explode(',', $validated['regions']))
            : [];
        $validated['status'] = $request->boolean('status');

        ShippingZone::create($validated);

        return redirect()->route('superadmin.shipping-zones.index')->with('success', 'Shipping zone created successfully.');
    }

    public function show(ShippingZone $shippingZone)
    {
        $shippingZone->load('shippingRates');

        return view('superadmin.shipping-zones.show', ['zone' => $shippingZone]);
    }

    public function edit(ShippingZone $shippingZone)
    {
        return view('superadmin.shipping-zones.edit', ['zone' => $shippingZone]);
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100|unique:shipping_zones,name,' . $shippingZone->id,
            'regions' => 'nullable|string',
            'status'  => 'boolean',
        ]);

        $validated['regions'] = $validated['regions']
            ? array_map('trim', explode(',', $validated['regions']))
            : [];
        $validated['status'] = $request->boolean('status');

        $shippingZone->update($validated);

        return redirect()->route('superadmin.shipping-zones.index')->with('success', 'Shipping zone updated successfully.');
    }

    public function destroy(ShippingZone $shippingZone)
    {
        if ($shippingZone->shippingRates()->exists()) {
            return redirect()->route('superadmin.shipping-zones.index')
                ->with('error', 'This zone has rates attached and cannot be deleted. Delete the rates first.');
        }

        $shippingZone->delete();

        return redirect()->route('superadmin.shipping-zones.index')->with('success', 'Shipping zone deleted successfully.');
    }
}
