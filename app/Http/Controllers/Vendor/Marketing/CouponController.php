<?php

namespace App\Http\Controllers\Vendor\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);

        return view('vendor.marketing.index', compact('coupons'));
    }

    public function create()
    {
        return view('vendor.marketing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Coupon
        ]);

        $coupon = Coupon::create($validated);

        return redirect()->route('vendor.marketing.index')->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        return view('vendor.marketing.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('vendor.marketing.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Coupon
        ]);

        $coupon->update($validated);

        return redirect()->route('vendor.marketing.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('vendor.marketing.index')->with('success', 'Coupon deleted successfully.');
    }
}
