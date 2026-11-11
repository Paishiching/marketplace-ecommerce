<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function index()
    {
        $resellers = Reseller::latest()->paginate(20);

        return response()->json($resellers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Reseller
        ]);

        $reseller = Reseller::create($validated);

        return response()->json($reseller, 201);
    }

    public function show(Reseller $reseller)
    {
        return response()->json($reseller);
    }

    public function update(Request $request, Reseller $reseller)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Reseller
        ]);

        $reseller->update($validated);

        return response()->json($reseller);
    }

    public function destroy(Reseller $reseller)
    {
        $reseller->delete();

        return response()->json(null, 204);
    }
}
