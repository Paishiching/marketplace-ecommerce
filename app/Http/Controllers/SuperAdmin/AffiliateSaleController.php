<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateSale;
use Illuminate\Http\Request;

class AffiliateSaleController extends Controller
{
    public const STATUSES = ['pending', 'approved', 'paid', 'rejected'];

    public function index(Request $request)
    {
        $sales = AffiliateSale::with(['affiliate.user', 'link'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('affiliate_id'), fn ($q) => $q->where('affiliate_id', $request->affiliate_id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = AffiliateSale::selectRaw('status, COUNT(*) as total, SUM(commission_amount) as sum')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $affiliates = Affiliate::with('user:id,name')->get(['id', 'user_id', 'referral_code']);

        return view('superadmin.affiliates.sales.index', [
            'sales'      => $sales,
            'summary'    => $summary,
            'affiliates' => $affiliates,
            'statuses'   => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, AffiliateSale $affiliateSale)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);

        $affiliateSale->update($data);

        return back()->with('success', 'Sale status updated.');
    }
}
