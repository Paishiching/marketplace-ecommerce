<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class DeliveryRateController extends Controller
{
    public function index(Request $request)
    {
        $query = ShippingRate::with('shippingZone')->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($zoneId = $request->input('zone')) {
            $query->where('shipping_zone_id', $zoneId);
        }

        $rates = $query->paginate(20)->withQueryString();
        $zones = ShippingZone::orderBy('name')->get();

        $stats = [
            'total' => ShippingRate::count(),
            'zones' => ShippingZone::count(),
        ];

        return view('superadmin.delivery-rates.index', compact('rates', 'zones', 'stats'));
    }

    public function create()
    {
        $rate = new ShippingRate();
        $zones = ShippingZone::where('status', true)->orderBy('name')->get();

        return view('superadmin.delivery-rates.create', compact('rate', 'zones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'name'             => 'required|string|max:100',
            'rate'             => 'required|numeric|min:0',
        ]);

        ShippingRate::create($validated);

        return redirect()->route('superadmin.delivery-rates.index')->with('success', 'Delivery rate created successfully.');
    }

    public function show(ShippingRate $deliveryRate)
    {
        $deliveryRate->load('shippingZone');

        return view('superadmin.delivery-rates.show', ['rate' => $deliveryRate]);
    }

    public function edit(ShippingRate $deliveryRate)
    {
        $zones = ShippingZone::orderBy('name')->get();

        return view('superadmin.delivery-rates.edit', ['rate' => $deliveryRate, 'zones' => $zones]);
    }

    public function update(Request $request, ShippingRate $deliveryRate)
    {
        $validated = $request->validate([
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'name'             => 'required|string|max:100',
            'rate'             => 'required|numeric|min:0',
        ]);

        $deliveryRate->update($validated);

        return redirect()->route('superadmin.delivery-rates.index')->with('success', 'Delivery rate updated successfully.');
    }

    public function destroy(ShippingRate $deliveryRate)
    {
        $deliveryRate->delete();

        return redirect()->route('superadmin.delivery-rates.index')->with('success', 'Delivery rate deleted successfully.');
    }
}
