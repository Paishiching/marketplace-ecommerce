<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public const STATUSES = ['pending', 'approved', 'paid', 'rejected'];

    public function index(Request $request)
    {
        $commissions = Commission::with(['vendor', 'affiliate', 'orderItem'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->type === 'vendor', fn ($q) => $q->whereNotNull('vendor_id'))
            ->when($request->type === 'affiliate', fn ($q) => $q->whereNotNull('affiliate_id'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $summary = Commission::selectRaw('status, COUNT(*) as total, SUM(amount) as sum')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return view('superadmin.commissions.index', [
            'commissions' => $commissions,
            'summary'     => $summary,
            'statuses'    => self::STATUSES,
        ]);
    }

    public function show(Commission $commission)
    {
        $commission->load(['vendor', 'affiliate', 'orderItem']);

        return view('superadmin.commissions.show', [
            'commission' => $commission,
            'statuses'   => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Commission $commission)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);

        $commission->update($data);

        return back()->with('success', 'Commission status updated.');
    }
}
