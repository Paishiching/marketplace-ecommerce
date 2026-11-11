<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Affiliate;

class AffiliateController extends PartnerController
{
    protected function cfg(): array
    {
        return [
            'model'  => Affiliate::class,
            'role'   => 'affiliate',
            'title'  => 'Affiliates',
            'prefix' => 'superadmin.affiliates',
            'name'   => 'referral_code',
            'rate'   => 'commission_rate',
            'rate_label' => 'Commission %',
            'verify' => false,
        ];
    }
}



//    public function index(Request $request)
//    {
//        $affiliates = Affiliate::with('user')
//            ->when($request->filled('search'), function ($query) use ($request) {
//                $search = $request->input('search');
//
//                $query->where(function ($q) use ($search) {
//                    $q->where('referral_code', 'like', "%{$search}%")
//                        ->orWhereHas('user', function ($u) use ($search) {
//                            $u->where('name', 'like', "%{$search}%")
//                                ->orWhere('email', 'like', "%{$search}%");
//                        });
//                });
//            })
//            ->when($request->filled('status'), function ($query) use ($request) {
//                $query->where('status', $request->input('status'));
//            })
//            ->latest()
//            ->paginate(20)
//            ->withQueryString();
//
//        return view('superadmin.affiliates.index', compact('affiliates'));
//    }
//
//    public function create()
//    {
//        $users = User::doesntHave('affiliate')->get(['id', 'name', 'email']);
//
//        return view('superadmin.affiliates.create', compact('users'));
//    }
//
//    public function store(Request $request)
//    {
//        $validated = $request->validate([
//            'user_id'         => ['required', 'exists:users,id', 'unique:affiliates,user_id'],
//            'referral_code'   => ['nullable', 'string', 'max:50', 'unique:affiliates,referral_code'],
//            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
//            'status'          => ['required', 'in:pending,approved,suspended'],
//        ]);
//
//        Affiliate::create([
//            'user_id'         => $validated['user_id'],
//            'referral_code'   => $validated['referral_code'] ?? $this->generateReferralCode(),
//            'commission_rate' => $validated['commission_rate'] ?? null,
//            'status'          => $validated['status'],
//        ]);
//
//        return redirect()->route('superadmin.affiliates.index')
//            ->with('success', 'Affiliate created successfully.');
//    }
//
//    public function show(Affiliate $affiliate)
//    {
//        $affiliate->load('user');
//
//        return view('superadmin.affiliates.show', compact('affiliate'));
//    }
//
//    public function edit(Affiliate $affiliate)
//    {
//        $affiliate->load('user');
//
//        $users = User::doesntHave('affiliate')
//            ->orWhere('id', $affiliate->user_id)
//            ->get(['id', 'name', 'email']);
//
//        return view('superadmin.affiliates.edit', compact('affiliate', 'users'));
//    }
//
//    public function update(Request $request, Affiliate $affiliate)
//    {
//        $validated = $request->validate([
//            'user_id'         => ['required', 'exists:users,id', 'unique:affiliates,user_id,' . $affiliate->id],
//            'referral_code'   => ['required', 'string', 'max:50', 'unique:affiliates,referral_code,' . $affiliate->id],
//            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
//        ]);
//
//        // status এখানে বদলায় না; approve/suspend button দিয়ে বদলাবে
//        $affiliate->update($validated);
//
//        return redirect()->route('superadmin.affiliates.index')
//            ->with('success', 'Affiliate updated successfully.');
//    }
//
//    public function destroy(Affiliate $affiliate)
//    {
//        try {
//            $affiliate->delete();
//        } catch (\Throwable $e) {
//            return back()->with('error', 'Could not delete affiliate: ' . $e->getMessage());
//        }
//
//        return redirect()->route('superadmin.affiliates.index')
//            ->with('success', 'Affiliate deleted successfully.');
//    }
//
//    public function approve(Affiliate $affiliate)
//    {
//        $affiliate->forceFill(['status' => 'approved'])->save();
//
//        return back()->with('success', 'Affiliate approved successfully.');
//    }
//
//    public function suspend(Affiliate $affiliate)
//    {
//        $affiliate->forceFill(['status' => 'suspended'])->save();
//
//        return back()->with('success', 'Affiliate suspended.');
//    }
//
//    private function generateReferralCode(): string
//    {
//        do {
//            $code = strtoupper(Str::random(8));
//        } while (Affiliate::where('referral_code', $code)->exists());
//
//        return $code;
//    }
//}
