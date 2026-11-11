<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DropshipperOrder;
use App\Models\DropshipperProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DropshipperStoreController extends Controller
{
    public function myOrders(Request $request): View
    {
        $customerId = Customer::where('user_id', $request->user()->id)->value('id');
        $orders = DropshipperOrder::with(['dropshipper', 'supplier', 'items'])
            ->where('customer_id', $customerId ?? 0)
            ->latest()
            ->paginate(15);

        return view('frontend.dropshipping.orders', compact('orders'));
    }

    public function show(DropshipperProduct $dropshipperProduct): View
    {
        $listing = $this->activeListing($dropshipperProduct);
        $listing->load(['dropshipper.user', 'supplierProduct.supplier', 'supplierProduct.product']);

        return view('frontend.dropshipping.show', compact('listing'));
    }

    public function order(Request $request, DropshipperProduct $dropshipperProduct): RedirectResponse
    {
        $listing = $this->activeListing($dropshipperProduct);
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:100000']]);
        $supplierProduct = $listing->supplierProduct()->with('supplier')->firstOrFail();
        $minimum = max(1, (int) ($supplierProduct->moq ?? 1));
        $quantity = (int) $data['quantity'];

        if ($quantity < $minimum) {
            return back()->withInput()->withErrors([
                'quantity' => 'The minimum order quantity for this product is ' . $minimum . '.',
            ]);
        }

        $unitCost = (float) $supplierProduct->base_price;
        $unitPrice = $unitCost + (float) $listing->markup_price;
        $salesTotal = round($unitPrice * $quantity, 2);
        $costTotal = round($unitCost * $quantity, 2);
        $customer = Customer::firstOrCreate(['user_id' => $request->user()->id]);

        $order = DB::transaction(function () use ($listing, $supplierProduct, $customer, $quantity, $unitCost, $unitPrice, $salesTotal, $costTotal) {
            $order = DropshipperOrder::create([
                'dropshipper_id' => $listing->dropshipper_id,
                'customer_id' => $customer->id,
                'supplier_id' => $supplierProduct->supplier_id,
                'status' => 'pending',
                'sales_total' => $salesTotal,
                'total_cost' => $costTotal,
                'profit' => round($salesTotal - $costTotal, 2),
            ]);

            $order->items()->create([
                'supplier_product_id' => $supplierProduct->id,
                'product_name' => $supplierProduct->name,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'unit_price' => $unitPrice,
                'line_total' => $salesTotal,
            ]);

            return $order;
        });

        return redirect()->route('dropship-products.show', $listing)
            ->with('success', 'Your order request has been sent. Reference: DSP-' . $order->id);
    }

    private function activeListing(DropshipperProduct $listing): DropshipperProduct
    {
        abort_unless(
            $listing->is_active
            && $listing->dropshipper?->status === 'approved'
            && in_array($listing->supplierProduct?->status, ['approved', 'active', 'published'], true)
            && $listing->supplierProduct?->supplier?->status === 'approved',
            404
        );

        return $listing;
    }
}
