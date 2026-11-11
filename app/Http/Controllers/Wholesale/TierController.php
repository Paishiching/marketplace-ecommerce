<?php

namespace App\Http\Controllers\Wholesale;

use App\Http\Controllers\Controller;
use App\Models\WholesaleProduct;
use App\Models\WholesaleTier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TierController extends Controller
{
    public function index(Request $request): View
    {
        $wholesaler = $request->user()->wholesaler;
        $tiers = WholesaleTier::with(['wholesaleProduct.product', 'wholesalePrice'])
            ->whereHas('wholesaleProduct', fn ($query) => $query->where('wholesaler_id', $wholesaler->id))
            ->latest()
            ->paginate(20);
        $products = WholesaleProduct::with('product:id,name')
            ->where('wholesaler_id', $wholesaler->id)
            ->where('is_wholesale_enabled', true)
            ->orderBy('id')
            ->get();

        return view('wholesale.tiers.index', compact('tiers', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $wholesaler = $request->user()->wholesaler;
        $data = $request->validate([
            'wholesale_product_id' => ['required', 'integer', 'exists:wholesale_products,id'],
            'min_quantity' => ['required', 'integer', 'min:1', 'max:100000000'],
            'max_quantity' => ['nullable', 'integer', 'gte:min_quantity', 'max:100000000'],
            'unit_price' => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
        ]);

        $product = WholesaleProduct::whereKey($data['wholesale_product_id'])
            ->where('wholesaler_id', $wholesaler->id)
            ->firstOrFail();

        $newMin = (int) $data['min_quantity'];
        $newMax = isset($data['max_quantity']) ? (int) $data['max_quantity'] : PHP_INT_MAX;
        $overlapsExistingTier = $product->wholesaleTiers()->get()->contains(function ($tier) use ($newMin, $newMax) {
            $existingMax = $tier->max_quantity === null ? PHP_INT_MAX : (int) $tier->max_quantity;

            return $newMin <= $existingMax && (int) $tier->min_quantity <= $newMax;
        });

        if ($overlapsExistingTier) {
            return back()->withInput()->withErrors([
                'min_quantity' => 'This quantity range overlaps an existing price tier. Choose a different range.',
            ]);
        }

        DB::transaction(function () use ($data, $product) {
            $tier = WholesaleTier::create([
                'wholesale_product_id' => $product->id,
                'min_quantity' => $data['min_quantity'],
                'max_quantity' => $data['max_quantity'] ?? null,
            ]);

            $tier->wholesalePrice()->create(['unit_price' => $data['unit_price']]);
        });

        return back()->with('success', 'Wholesale price tier created.');
    }

    public function destroy(Request $request, WholesaleTier $tier): RedirectResponse
    {
        abort_unless($tier->wholesaleProduct()->where('wholesaler_id', $request->user()->wholesaler?->id)->exists(), 404);
        $tier->delete();

        return back()->with('success', 'Wholesale price tier removed.');
    }
}
