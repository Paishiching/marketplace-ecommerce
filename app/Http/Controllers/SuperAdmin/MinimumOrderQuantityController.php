<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MinimumOrderQuantity;
use App\Models\WholesaleProduct;
use Illuminate\Http\Request;

class MinimumOrderQuantityController extends Controller
{
    public function index()
    {
        $items = MinimumOrderQuantity::with('wholesaleProduct.product')->latest()->paginate(15);
        $wholesaleProducts = WholesaleProduct::with('product:id,name')->get();

        return view('superadmin.wholesale.moq.index', compact('items', 'wholesaleProducts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wholesale_product_id' => 'required|exists:wholesale_products,id',
            'moq'                  => 'required|integer|min:1',
        ]);

        MinimumOrderQuantity::updateOrCreate(
            ['wholesale_product_id' => $data['wholesale_product_id']],
            ['moq' => $data['moq']]
        );

        return back()->with('success', 'Minimum order quantity saved.');
    }

    public function destroy(MinimumOrderQuantity $minimumOrderQuantity)
    {
        $minimumOrderQuantity->delete();

        return back()->with('success', 'Minimum order quantity removed.');
    }
}
