<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\AffiliateLink;
use Illuminate\Support\Facades\Auth;

class ClickController extends Controller
{
    public function index()
    {
        $affiliate = Auth::user()->affiliate;
        abort_if(!$affiliate, 403, 'Affiliate profile not found.');

        $linkIds = AffiliateLink::where('affiliate_id', $affiliate->id)->select('id');

        $clicks = AffiliateClick::with('link.product:id,name')
            ->whereIn('affiliate_link_id', $linkIds)
            ->latest()
            ->paginate(20);

        return view('affiliate.clicks.index', compact('clicks'));
    }
}
