<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::latest()->paginate(20);

        return response()->json($shipments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment = Shipment::create($validated);

        return response()->json($shipment, 201);
    }

    public function show(Shipment $shipment)
    {
        return response()->json($shipment);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Shipment
        ]);

        $shipment->update($validated);

        return response()->json($shipment);
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return response()->json(null, 204);
    }
}
