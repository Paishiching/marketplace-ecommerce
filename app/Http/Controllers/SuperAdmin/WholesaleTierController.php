<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\WholesalePrice;
use App\Models\WholesaleProduct;
use App\Models\WholesaleTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WholesaleTierController extends Controller
{
    public function index()
    {
        $tiers = WholesaleTier::with(['wholesaleProduct.product', 'wholesalePrice'])
            ->orderBy('wholesale_product_id')
            ->orderBy('min_quantity')
            ->paginate(20);

        $wholesaleProducts = WholesaleProduct::with('product:id,name')->get();

        return view('superadmin.wholesale.tiers.index', compact('tiers', 'wholesaleProducts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wholesale_product_id' => 'required|exists:wholesale_products,id',
            'min_quantity'         => 'required|integer|min:1',
            'max_quantity'         => 'nullable|integer|gte:min_quantity',
            'unit_price'           => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($data) {
            $tier = WholesaleTier::create([
                'wholesale_product_id' => $data['wholesale_product_id'],
                'min_quantity'         => $data['min_quantity'],
                'max_quantity'         => $data['max_quantity'] ?? null,
            ]);

            WholesalePrice::create([
                'wholesale_tier_id' => $tier->id,
                'unit_price'        => $data['unit_price'],
            ]);
        });

        return back()->with('success', 'Pricing tier added.');
    }

    public function destroy(WholesaleTier $wholesaleTier)
    {
        DB::transaction(function () use ($wholesaleTier) {
            WholesalePrice::where('wholesale_tier_id', $wholesaleTier->id)->delete();
            $wholesaleTier->delete();
        });

        return back()->with('success', 'Pricing tier deleted.');
    }
}
