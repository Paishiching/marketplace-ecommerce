<?php

namespace App\Http\Controllers\Vendor\Finance;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorOrder;
use App\Models\Withdrawal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $vendor = $this->vendor();

        $credits = VendorOrder::with('order:id,order_number,status')
            ->where('vendor_id', $vendor->id)
            ->whereHas('order', fn ($q) => $q->whereIn('status', ['delivered', 'completed']))
            ->get()
            ->map(fn ($r) => [
                'date'   => $r->created_at,
                'type'   => 'credit',
                'label'  => 'Order #' . ($r->order->order_number ?? $r->order_id) . ' earning',
                'amount' => (float) $r->subtotal - (float) $r->commission_amount,
                'status' => $r->order->status ?? '',
            ]);

        $debits = Withdrawal::where('withdrawable_type', Vendor::class)
            ->where('withdrawable_id', $vendor->id)
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->get()
            ->map(fn ($w) => [
                'date'   => $w->created_at,
                'type'   => 'debit',
                'label'  => 'Withdraw (' . $w->method . ')',
                'amount' => (float) $w->amount,
                'status' => $w->status,
            ]);

        $all = $credits->concat($debits)->sortByDesc('date')->values();

        $perPage = 20;
        $page    = LengthAwarePaginator::resolveCurrentPage();
        $rows    = new LengthAwarePaginator(
            $all->forPage($page, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('vendor.transactions.index', ['transactions' => $rows]);
    }

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }
}