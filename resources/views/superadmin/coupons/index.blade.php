@extends('layouts.superadmin.app')

@section('title', 'Coupons')

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
                            <li class="breadcrumb-item active" aria-current="page">Coupons</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.coupons.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add Coupon
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- STATS --}}
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3">
                @php
                    $cards = [
                        ['Total Coupons', $stats['total'],   'bx-purchase-tag', 'primary'],
                        ['Active Now',    $stats['active'],  'bx-check-circle', 'success'],
                        ['Expired',       $stats['expired'], 'bx-time-five',    'danger'],
                        ['Total Redemptions', $stats['used'], 'bx-receipt',     'info'],
                    ];
                @endphp
                @foreach ($cards as [$label, $count, $icon, $color])
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-4 border-{{ $color }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">{{ $label }}</p>
                                        <h4 class="my-1">{{ number_format($count) }}</h4>
                                    </div>
                                    <div class="ms-auto fs-1 text-{{ $color }}"><i class="bx {{ $icon }}"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- FILTERS --}}
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('superadmin.coupons.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Coupon code..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Status</label>
                            <select name="state" class="form-select">
                                <option value="">All</option>
                                @foreach (['active' => 'Active', 'scheduled' => 'Scheduled', 'expired' => 'Expired', 'inactive' => 'Inactive'] as $k => $v)
                                    <option value="{{ $k }}" {{ request('state') === $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-primary flex-fill" type="submit"><i class="bx bx-filter-alt"></i> Filter</button>
                            <a href="{{ route('superadmin.coupons.index') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Min Order</th>
                                <th style="min-width:160px;">Usage</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($coupons as $coupon)
                                @php
                                    $used = $coupon->coupon_usages_count;
                                    $limit = $coupon->usage_limit;
                                    $pct = $limit ? min(100, round($used / $limit * 100)) : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('superadmin.coupons.show', $coupon) }}" class="fw-bold text-primary">
                                            {{ $coupon->code }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $coupon->discount_label }}</span>
                                        <div class="small text-muted">{{ $coupon->type === 'percentage' ? 'Percentage' : 'Fixed' }}</div>
                                    </td>
                                    <td>
                                        {{ $coupon->min_order_amount > 0 ? $currency . number_format($coupon->min_order_amount, 2) : '—' }}
                                    </td>
                                    <td>
                                        <div class="small mb-1">
                                            {{ $used }} / {{ $limit ?: '∞' }}
                                        </div>
                                        @if ($limit)
                                            <div class="progress" style="height:6px;">
                                                <div class="progress-bar {{ $pct >= 100 ? 'bg-danger' : 'bg-primary' }}" style="width: {{ $pct }}%"></div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="small">
                                        <div>{{ $coupon->starts_at ? $coupon->starts_at->format('d M Y, h:i A') : 'Immediately' }}</div>
                                        <div class="text-muted">→ {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y, h:i A') : 'No expiry' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $coupon->state_badge }} text-capitalize">{{ $coupon->state }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('superadmin.coupons.show', $coupon) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bx bx-show"></i></a>
                                        <a href="{{ route('superadmin.coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('superadmin.coupons.destroy', $coupon) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('এই coupon টি delete করবেন?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-purchase-tag fs-1 d-block mb-2"></i>
                                        কোনো coupon পাওয়া যায়নি।
                                        <div class="mt-2">
                                            <a href="{{ route('superadmin.coupons.create') }}" class="btn btn-sm btn-primary">Create your first coupon</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
