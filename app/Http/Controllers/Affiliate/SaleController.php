<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $affiliate = Auth::user()->affiliate;
        abort_if(!$affiliate, 403, 'Affiliate profile not found.');

        $base = AffiliateSale::where('affiliate_id', $affiliate->id);

        $summary = (clone $base)
            ->selectRaw('status, COUNT(*) as total, SUM(commission_amount) as commission')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $sales = (clone $base)
            ->with(['order:id,order_number', 'link.product:id,name'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('affiliate.sales.index', compact('sales', 'summary'));
    }
}
