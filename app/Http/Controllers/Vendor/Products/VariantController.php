<?php

namespace App\Http\Controllers\Vendor\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index(Request $request)
    {
        $vendor = $this->vendor();

        $products = Product::where('vendor_id', $vendor->id)
            ->with(['productVariants', 'colorValues', 'sizeValues'])
            ->when(trim((string) $request->input('q')) !== '', function ($q) use ($request) {
                $s = trim((string) $request->input('q'));
                $q->where(function ($w) use ($s) {
                    $w->where('name', 'like', "%{$s}%")->orWhere('sku', 'like', "%{$s}%");
                });
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('vendor.variants.index', compact('products'));
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