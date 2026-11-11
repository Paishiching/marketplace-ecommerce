<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Reseller;
use App\Models\Supplier;
use App\Models\Vendor;
use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public const STATUSES = ['pending', 'approved', 'paid', 'rejected'];

    private const TYPES = [
        'vendor'    => Vendor::class,
        'supplier'  => Supplier::class,
        'affiliate' => Affiliate::class,
        'reseller'  => Reseller::class,
    ];

    public function index(Request $request)
    {
        $withdrawals = Withdrawal::with(['withdrawable' => function (MorphTo $morph) {
            $morph->morphWith([Affiliate::class => ['user']]);
        }])
            ->when(isset(self::TYPES[$request->type]), fn ($q) => $q->where('withdrawable_type', self::TYPES[$request->type]))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = Withdrawal::selectRaw('status, COUNT(*) as total, SUM(amount) as sum')
            ->when(isset(self::TYPES[$request->type]), fn ($q) => $q->where('withdrawable_type', self::TYPES[$request->type]))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return view('superadmin.withdrawals.index', [
            'withdrawals' => $withdrawals,
            'summary'     => $summary,
            'statuses'    => self::STATUSES,
            'types'       => array_keys(self::TYPES),
        ]);
    }

    public function updateStatus(Request $request, Withdrawal $withdrawal)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
            'note'   => 'nullable|string|max:500',
        ]);

        $withdrawal->update([
            'status'       => $data['status'],
            'note'         => $data['note'] ?? $withdrawal->note,
            'processed_at' => $data['status'] === 'pending' ? null : now(),
        ]);

        return back()->with('success', 'Withdrawal status updated.');
    }
    public function create()
    {
        return view('super-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Withdrawal
        ]);

        $withdrawal = Withdrawal::create($validated);

        return redirect()->route('super-admin.index')->with('success', 'Withdrawal created successfully.');
    }

    public function show(Withdrawal $withdrawal)
    {
        return view('super-admin.show', compact('withdrawal'));
    }

    public function edit(Withdrawal $withdrawal)
    {
        return view('super-admin.edit', compact('withdrawal'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Withdrawal
        ]);

        $withdrawal->update($validated);

        return redirect()->route('super-admin.index')->with('success', 'Withdrawal updated successfully.');
    }

    public function destroy(Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        return redirect()->route('super-admin.index')->with('success', 'Withdrawal deleted successfully.');
    }
}
