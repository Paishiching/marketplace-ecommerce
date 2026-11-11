<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateClick;
use Illuminate\Http\Request;

class AffiliateClickController extends Controller
{
    public function index(Request $request)
    {
        $clicks = AffiliateClick::with('link.affiliate.user')
            ->when($request->filled('affiliate_id'), fn ($q) => $q->whereHas(
                'link', fn ($l) => $l->where('affiliate_id', $request->affiliate_id)
            ))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => AffiliateClick::count(),
            'today' => AffiliateClick::whereDate('created_at', today())->count(),
        ];

        $affiliates = Affiliate::with('user:id,name')->get(['id', 'user_id', 'referral_code']);

        return view('superadmin.affiliates.clicks.index', compact('clicks', 'stats', 'affiliates'));
    }
}
