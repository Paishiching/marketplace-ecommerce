<?php

namespace App\Http\Controllers\Vendor\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Vendor;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    private const LOW_STOCK = 5;

    public function index(Request $request)
    {
        $vendor = $this->vendor();

        $products = Product::where('vendor_id', $vendor->id)
            ->with('productVariants')
            ->when(trim((string) $request->input('q')) !== '', function ($q) use ($request) {
                $s = trim((string) $request->input('q'));
                $q->where(function ($w) use ($s) {
                    $w->where('name', 'like', "%{$s}%")->orWhere('sku', 'like', "%{$s}%");
                });
            })
            ->when($request->query('stock') === 'low', fn ($q) => $q->whereHas(
                'productVariants', fn ($v) => $v->where('stock_quantity', '<=', self::LOW_STOCK)
            ))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $lowStock = self::LOW_STOCK;

        return view('vendor.inventory.index', compact('products', 'lowStock'));
    }

    public function update(Request $request, $id)
    {
        $vendor = $this->vendor();

        $data = $request->validate([
            'stock_quantity' => ['required', 'integer', 'min:0', 'max:1000000'],
        ]);

        // Onner vendor er variant hole 404
        $variant = ProductVariant::whereIn('product_id', Product::where('vendor_id', $vendor->id)->select('id'))
            ->findOrFail($id);

        $variant->update(['stock_quantity' => $data['stock_quantity']]);

        return back()->with('success', 'Stock update hoyeche.');
    }

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }
}