@extends('layouts.superadmin.app')

@section('title', 'Vendor Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Vendors</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.vendors.index') }}">Vendors</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $vendor->shop_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('superadmin.vendors.edit', $vendor->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('superadmin.vendors.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
            </div>
            <!--end breadcrumb-->

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

            <div class="row">

                <!-- LEFT -->
                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm overflow-hidden">
                        @if ($vendor->banner)
                            <img src="{{ asset('storage/' . $vendor->banner) }}" alt="banner" style="width:100%;max-height:200px;object-fit:cover;">
                        @endif
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3">
                                @if ($vendor->logo)
                                    <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->shop_name }}" width="80" height="80" style="object-fit:cover;border-radius:10px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width:80px;height:80px;border-radius:10px;">
                                        <i class="bx bx-store fs-2 text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="mb-1">{{ $vendor->shop_name }}</h4>
                                    <div class="text-muted small">/{{ $vendor->shop_slug }}</div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="text-uppercase text-muted mb-2">Description</h6>
                            <p class="mb-0">{{ $vendor->description ?: 'No description provided.' }}</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bx bx-user text-primary"></i> Owner
                            </h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="text-muted small">Name</div>
                                    <div class="fw-semibold">{{ $vendor->user->name ?? '—' }}</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="text-muted small">Email</div>
                                    <div class="fw-semibold">{{ $vendor->user->email ?? '—' }}</div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="text-muted small">Phone</div>
                                    <div class="fw-semibold">{{ $vendor->user->phone ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /LEFT -->

                <!-- RIGHT -->
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bx bx-shield-quarter text-primary"></i> Approval
                            </h5>
                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Status</span>
                                @if ($vendor->status === 'approved')
                                    <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Approved</span>
                                @elseif ($vendor->status === 'suspended')
                                    <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Suspended</span>
                                @else
                                    <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Verification</span>
                                @if ($vendor->verification_status === 'verified')
                                    <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Verified</span>
                                @elseif ($vendor->verification_status === 'rejected')
                                    <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Rejected</span>
                                @else
                                    <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                @endif
                            </div>

                            @include('superadmin.partials.approval-buttons', [
                                'model'       => $vendor,
                                'routePrefix' => 'superadmin.vendors',
                                'canReject'   => true,
                            ])
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bx bx-bar-chart-alt-2 text-primary"></i> Overview
                            </h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Commission</span>
                                <strong>{{ $vendor->commission_rate !== null ? rtrim(rtrim(number_format($vendor->commission_rate, 2), '0'), '.') . '%' : '—' }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Products</span>
                                <strong>{{ $stats['products'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Orders</span>
                                <strong>{{ $stats['orders'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="text-muted">Joined</span>
                                <strong>{{ $vendor->created_at->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /RIGHT -->

            </div>
        </div>
    </div>
@endsection
