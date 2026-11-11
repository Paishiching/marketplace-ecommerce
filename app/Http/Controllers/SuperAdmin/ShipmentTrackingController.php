<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentTrackingController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with('courier')->withCount('trackingEvents')->latest();

        if ($search = $request->input('search')) {
            $query->where('tracking_number', 'like', '%' . $search . '%');
        }

        $shipments = $query->paginate(20)->withQueryString();

        return view('superadmin.shipment-tracking.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        $events = $shipment->trackingEvents()->orderBy('event_time', 'desc')->get();

        return view('superadmin.shipment-tracking.show', compact('shipment', 'events'));
    }
}
