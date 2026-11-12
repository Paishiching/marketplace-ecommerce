<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::withCount('couponUsages')->latest();

        // Search by code
        if ($search = $request->input('search')) {
            $query->where('code', 'like', '%' . $search . '%');
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Filter by state (computed, so we translate to query conditions)
        if ($state = $request->input('state')) {
            $now = Carbon::now();

            match ($state) {
            'active' => $query->where('status', true)
                ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
                ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now)),

                'scheduled' => $query->where('status', true)
                ->whereNotNull('starts_at')
                ->where('starts_at', '>', $now),

                'expired' => $query->whereNotNull('expires_at')
                ->where('expires_at', '<', $now),

                'inactive' => $query->where('status', false),

                default => null,
            };
        }

        $coupons = $query->paginate(20)->withQueryString();

        $stats = [
            'total'   => Coupon::count(),
            'active'  => Coupon::live()->count(),
            'expired' => Coupon::expired()->count(),
            'used'    => \App\Models\CouponUsage::count(),
        ];

        return view('superadmin.coupons.index', compact('coupons', 'stats'));
    }

    public function create()
    {
        $coupon = new Coupon();

        return view('superadmin.coupons.create', compact('coupon'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'             => 'required|string|max:50|unique:coupons,code',
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'starts_at'        => 'nullable|date',
            'expires_at'       => 'nullable|date|after_or_equal:starts_at',
            'status'           => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['status'] = $request->boolean('status');
        $validated = $this->storeDhakaDateTimesAsUtc($validated);

        Coupon::create($validated);

        return redirect()->route('superadmin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->loadCount('couponUsages');

        return view('superadmin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('superadmin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code'             => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'starts_at'        => 'nullable|date',
            'expires_at'       => 'nullable|date|after_or_equal:starts_at',
            'status'           => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['status'] = $request->boolean('status');
        $validated = $this->storeDhakaDateTimesAsUtc($validated);

        $coupon->update($validated);

        return redirect()->route('superadmin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('superadmin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    /** datetime-local inputs represent Bangladesh time; persist their UTC equivalent. */
    private function storeDhakaDateTimesAsUtc(array $validated): array
    {
        foreach (['starts_at', 'expires_at'] as $field) {
            if (! empty($validated[$field])) {
                $validated[$field] = Carbon::parse($validated[$field], 'Asia/Dhaka')->utc()->format('Y-m-d H:i:s');
            }
        }

        return $validated;
    }
}
