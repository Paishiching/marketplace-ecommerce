<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(20);

        return response()->json($vendors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Vendor
        ]);

        $vendor = Vendor::create($validated);

        return response()->json($vendor, 201);
    }

    public function show(Vendor $vendor)
    {
        return response()->json($vendor);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Vendor
        ]);

        $vendor->update($validated);

        return response()->json($vendor);
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return response()->json(null, 204);
    }
}
