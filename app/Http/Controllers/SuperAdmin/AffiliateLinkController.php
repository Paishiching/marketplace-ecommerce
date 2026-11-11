<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateLink;
use Illuminate\Http\Request;

class AffiliateLinkController extends Controller
{
    public function index(Request $request)
    {
        $links = AffiliateLink::with(['affiliate.user', 'product'])
            ->withCount(['clicks', 'sales'])
            ->when($request->filled('affiliate_id'), fn ($q) => $q->where('affiliate_id', $request->affiliate_id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $affiliates = Affiliate::with('user:id,name')->get(['id', 'user_id', 'referral_code']);

        return view('superadmin.affiliates.links.index', compact('links', 'affiliates'));
    }

    public function toggle(AffiliateLink $affiliateLink)
    {
        $affiliateLink->update(['is_active' => ! $affiliateLink->is_active]);

        return back()->with('success', 'Link status updated.');
    }
}
