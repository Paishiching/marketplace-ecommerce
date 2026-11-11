<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\ResellerPrice;
use App\Models\ResellerProduct;
use Illuminate\Http\Request;

class ResellerPricingController extends Controller
{
    public function index(Request $request)
    {
        $items = ResellerProduct::with(['reseller', 'product', 'price'])
            ->when($request->filled('reseller_id'), fn ($q) => $q->where('reseller_id', $request->reseller_id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $resellers = Reseller::orderBy('business_name')->get(['id', 'business_name']);

        return view('superadmin.resellers.pricing.index', compact('items', 'resellers'));
    }

    public function update(Request $request, ResellerProduct $resellerProduct)
    {
        $data = $request->validate([
            'selling_price' => 'required|numeric|min:0',
        ]);

        ResellerPrice::updateOrCreate(
            ['reseller_product_id' => $resellerProduct->id],
            ['selling_price' => $data['selling_price']]
        );

        return back()->with('success', 'Selling price updated.');
    }
}
