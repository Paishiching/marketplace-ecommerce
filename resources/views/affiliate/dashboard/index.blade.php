@extends('layouts.affiliate.app')

@section('title', 'Affiliate Dashboard')

@section('panel_content')
    <div class="card mb-3"><div class="card-body p-4"><h4 class="fw-bold mb-1">Welcome, {{ $user->name }}!</h4><p class="text-muted mb-0">Track your referral links, clicks, sales, and commission here.</p></div></div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
        <div class="col"><div class="card radius-10 h-100"><div class="card-body"><p class="mb-1 text-secondary">Referral links</p><h4 class="mb-0">{{ number_format($totalLinks) }}</h4></div></div></div>
        <div class="col"><div class="card radius-10 h-100"><div class="card-body"><p class="mb-1 text-secondary">Total clicks</p><h4 class="mb-0">{{ number_format($totalClicks) }}</h4></div></div></div>
        <div class="col"><div class="card radius-10 h-100"><div class="card-body"><p class="mb-1 text-secondary">Sales</p><h4 class="mb-0">{{ number_format($totalSales) }}</h4><small class="text-secondary">{{ number_format($conversionRate, 2) }}% conversion</small></div></div></div>
        <div class="col"><div class="card radius-10 h-100"><div class="card-body"><p class="mb-1 text-secondary">Available balance</p><h4 class="mb-0">BDT {{ number_format((float) $availableBalance, 2) }}</h4><small class="text-secondary">Pending: BDT {{ number_format((float) $pendingCommission, 2) }}</small></div></div></div>
    </div>

    <div class="card"><div class="card-header bg-white"><h5 class="mb-0">Recent sales</h5></div><div class="card-body"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Date</th><th>Sale amount</th><th>Commission</th><th>Status</th></tr></thead><tbody>
        @forelse ($recentSales as $sale)
            <tr><td>{{ $sale->created_at?->format('d M Y') ?? '—' }}</td><td>BDT {{ number_format((float) $sale->sale_amount, 2) }}</td><td>BDT {{ number_format((float) $sale->commission_amount, 2) }}</td><td><span class="badge text-bg-light">{{ ucfirst($sale->status) }}</span></td></tr>
        @empty
            <tr><td colspan="4" class="text-center text-secondary py-4">No affiliate sales yet. Share your referral links to get started.</td></tr>
        @endforelse
    </tbody></table></div></div></div>
@endsection
