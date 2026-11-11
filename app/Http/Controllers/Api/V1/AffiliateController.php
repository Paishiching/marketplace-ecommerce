<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        $affiliates = Affiliate::latest()->paginate(20);

        return response()->json($affiliates);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Affiliate
        ]);

        $affiliate = Affiliate::create($validated);

        return response()->json($affiliate, 201);
    }

    public function show(Affiliate $affiliate)
    {
        return response()->json($affiliate);
    }

    public function update(Request $request, Affiliate $affiliate)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Affiliate
        ]);

        $affiliate->update($validated);

        return response()->json($affiliate);
    }

    public function destroy(Affiliate $affiliate)
    {
        $affiliate->delete();

        return response()->json(null, 204);
    }
}
