@extends('layouts.superadmin.app')

@section('title', 'Coupon: ' . $coupon->code)

@section('content')
    @php $currency = $siteSettings->currency_symbol ?? '৳'; @endphp
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Marketing</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.coupons.index') }}">Coupons</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $coupon->code }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.coupons.edit', $coupon) }}" class="btn btn-primary"><i class="bx bx-edit"></i> Edit</a>
                    <a href="{{ route('superadmin.coupons.index') }}" class="btn btn-light">Back</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                $used = $coupon->coupon_usages_count;
                $limit = $coupon->usage_limit;
                $pct = $limit ? min(100, round($used / $limit * 100)) : 0;
            @endphp

            <div class="row">
                {{-- LEFT: DETAILS --}}
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body p-4 text-center">
                            <div class="p-3 rounded mb-3" style="border:2px dashed #0d6efd;">
                                <div class="text-muted small">Coupon Code</div>
                                <div class="fs-3 fw-bold text-primary">{{ $coupon->code }}</div>
                                <div class="fs-5">{{ $coupon->discount_label }} OFF</div>
                            </div>
                            <span class="badge {{ $coupon->state_badge }} text-capitalize fs-6">{{ $coupon->state }}</span>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Details</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Type</span>
                                    <span>{{ $coupon->type === 'percentage' ? 'Percentage' : 'Fixed Amount' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Min Order</span>
                                    <span>{{ $coupon->min_order_amount > 0 ? $currency . number_format($coupon->min_order_amount, 2) : 'None' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Starts</span>
                                    <span>{{ $coupon->starts_at ? $coupon->starts_at->format('d M Y, h:i A') : 'Immediately' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Expires</span>
                                    <span>{{ $coupon->expires_at ? $coupon->expires_at->format('d M Y, h:i A') : 'Never' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Created</span>
                                    <span>{{ $coupon->created_at?->format('d M Y') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <h6 class="mb-2">Usage</h6>
                            <div class="d-flex justify-content-between small mb-1">
                                <span>{{ $used }} used</span>
                                <span>{{ $limit ? $limit . ' limit' : 'Unlimited' }}</span>
                            </div>
                            @if ($limit)
                                <div class="progress" style="height:8px;">
                                    <div class="progress-bar {{ $pct >= 100 ? 'bg-danger' : 'bg-primary' }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <small class="text-muted">{{ max(0, $limit - $used) }} টি বাকি আছে</small>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: USAGE HISTORY --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Usage History</h6>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Order</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($usages as $usage)
                                        <tr>
                                            <td>{{ $usages->firstItem() + $loop->index }}</td>
                                            <td>{{ $usage->customer->name ?? ('Customer #' . $usage->customer_id) }}</td>
                                            <td>{{ $usage->order->order_number ?? ('Order #' . $usage->order_id) }}</td>
                                            <td>{{ $usage->created_at?->format('d M Y, h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">এই coupon এখনো কেউ ব্যবহার করেনি।</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $usages->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
