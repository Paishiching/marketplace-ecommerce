<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateClick;
use App\Models\AffiliateLink;
use App\Models\AffiliateSale;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $affiliate = $user->affiliate;
        abort_if(!$affiliate, 403, 'Affiliate profile not found.');

        $id = $affiliate->id;

        $totalLinks  = AffiliateLink::where('affiliate_id', $id)->count();
        $totalClicks = AffiliateClick::whereIn(
            'affiliate_link_id',
            AffiliateLink::where('affiliate_id', $id)->select('id')
        )->count();

        $sales      = AffiliateSale::where('affiliate_id', $id);
        $totalSales = (clone $sales)->count();

        $pendingCommission  = (clone $sales)->where('status', 'pending')->sum('commission_amount');
        $approvedCommission = (clone $sales)->whereIn('status', ['approved', 'paid'])->sum('commission_amount');

        $withdrawn = Withdrawal::where('withdrawable_type', Affiliate::class)
            ->where('withdrawable_id', $id)
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->sum('amount');

        $availableBalance = max(0, $approvedCommission - $withdrawn);
        $conversionRate   = $totalClicks > 0 ? round(($totalSales / $totalClicks) * 100, 2) : 0;

        $recentSales = AffiliateSale::where('affiliate_id', $id)
            ->latest()
            ->limit(5)
            ->get();

        return view('affiliate.dashboard.index', compact(
            'user',
            'affiliate',
            'totalLinks',
            'totalClicks',
            'totalSales',
            'pendingCommission',
            'approvedCommission',
            'availableBalance',
            'conversionRate',
            'recentSales'
        ));
    }
}
