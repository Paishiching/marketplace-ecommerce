<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use App\Models\Customer;
use App\Models\WholesaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WholesaleController extends Controller
{
    public function index(): View
    {
        $products = WholesaleProduct::with([
            'product',
            'wholesaler',
            'minimumOrderQuantity',
            'wholesaleTiers.wholesalePrice',
        ])
            ->where('is_wholesale_enabled', true)
            ->whereHas('product', fn ($query) => $query->where('status', 'published'))
            ->latest()
            ->paginate(18);

        return view('frontend.wholesale.index', compact('products'));
    }

    public function show(WholesaleProduct $wholesaleProduct): View
    {
        abort_unless($wholesaleProduct->is_wholesale_enabled && $wholesaleProduct->product?->status === 'published', 404);
        $wholesaleProduct->load(['product.primaryImage', 'wholesaler', 'minimumOrderQuantity', 'wholesaleTiers.wholesalePrice']);

        return view('frontend.wholesale.show', compact('wholesaleProduct'));
    }

    public function placeBulkOrder(Request $request, WholesaleProduct $wholesaleProduct): RedirectResponse
    {
        abort_unless($wholesaleProduct->is_wholesale_enabled && $wholesaleProduct->product?->status === 'published', 404);
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:1000000']]);
        $wholesaleProduct->load(['product', 'minimumOrderQuantity', 'wholesaleTiers.wholesalePrice']);
        $minimum = max(1, (int) ($wholesaleProduct->minimumOrderQuantity?->moq ?? 1));
        $quantity = (int) $data['quantity'];

        if ($quantity < $minimum) {
            return back()->withInput()->withErrors(['quantity' => 'The minimum order quantity for this product is ' . $minimum . '.']);
        }

        $tier = $wholesaleProduct->wholesaleTiers->sortBy('min_quantity')->first(function ($tier) use ($quantity) {
            return $quantity >= $tier->min_quantity && ($tier->max_quantity === null || $quantity <= $tier->max_quantity);
        });
        $unitPrice = (float) ($tier?->wholesalePrice?->unit_price ?? $wholesaleProduct->product->discount_price ?? $wholesaleProduct->product->price);
        $customer = Customer::firstOrCreate(['user_id' => $request->user()->id]);

        DB::transaction(function () use ($customer, $wholesaleProduct, $quantity, $unitPrice) {
            BulkOrder::create([
                'customer_id' => $customer->id,
                'wholesaler_id' => $wholesaleProduct->wholesaler_id,
                'wholesale_product_id' => $wholesaleProduct->id,
                'quantity' => $quantity,
                'total_price' => round($unitPrice * $quantity, 2),
                'status' => 'pending',
            ]);
        });

        return redirect()->route('wholesales.show', $wholesaleProduct)->with('success', 'Your bulk order request has been placed.');
    }
}
