@extends('layouts.vendor.panel')

@section('title', 'Vendor Dashboard')

@section('content')

    @unless($vendor)
        <div class="alert alert-warning">
            Apnar vendor profile ekhono toiri hoyni. Super Admin er shathe jogajog korun.
        </div>
    @endunless

    <div class="vp-card p-4 mb-4">
        <h4 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }}!</h4>
        <p class="text-muted mb-0">Apnar shop er product, order ar earning ekhane dekhte paren.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="vp-card p-4 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:54px;height:54px"><i class="bi bi-box-seam fs-4"></i></div>
                <div><small class="text-muted fw-semibold">Total Products</small><div class="fs-3 fw-bold">{{ $stats['products'] }}</div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="vp-card p-4 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width:54px;height:54px"><i class="bi bi-cart-check fs-4"></i></div>
                <div><small class="text-muted fw-semibold">Total Orders</small><div class="fs-3 fw-bold">{{ $stats['orders'] }}</div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="vp-card p-4 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width:54px;height:54px"><i class="bi bi-cash-coin fs-4"></i></div>
                <div><small class="text-muted fw-semibold">Total Sales</small><div class="fs-3 fw-bold">Tk. {{ number_format($stats['sales'], 2) }}</div></div>
            </div>
        </div>
    </div>

    <div class="vp-card">
        <div class="p-4 border-bottom"><h5 class="fw-bold mb-0">Recent Orders</h5></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                <tr><th class="ps-4">Order No</th><th>Qty</th><th>Amount</th><th>Date</th></tr>
                </thead>
                <tbody>
                @forelse($recentItems as $item)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">#{{ $item->order->order_number ?? $item->order_id }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Tk. {{ number_format($item->total_price, 2) }}</td>
                        <td>{{ $item->created_at?->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-5">Ekhono kono order nei.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
