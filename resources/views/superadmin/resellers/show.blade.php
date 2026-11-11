@extends('layouts.superadmin.app')

@section('title', 'Reseller Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Resellers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.resellers.index') }}">Resellers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $reseller->business_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('superadmin.resellers.edit', $reseller->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('superadmin.resellers.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bx bx-store text-primary"></i> Reseller Info
                            </h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Business Name</div>
                                    <div class="fw-semibold">{{ $reseller->business_name }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Owner</div>
                                    <div class="fw-semibold">{{ $reseller->user->name ?? '—' }}</div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="text-muted small">Email</div>
                                    <div class="fw-semibold">{{ $reseller->user->email ?? '—' }}</div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="text-muted small">Phone</div>
                                    <div class="fw-semibold">{{ $reseller->user->phone ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bx bx-shield-quarter text-primary"></i> Approval
                            </h5>
                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Status</span>
                                @if ($reseller->status === 'approved')
                                    <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Approved</span>
                                @elseif ($reseller->status === 'suspended')
                                    <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Suspended</span>
                                @else
                                    <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                @endif
                            </div>

                            @include('superadmin.partials.approval-buttons', [
                                'model'       => $reseller,
                                'routePrefix' => 'superadmin.resellers',
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
                                <span class="text-muted">Markup</span>
                                <strong>{{ $reseller->markup_rate !== null ? rtrim(rtrim(number_format($reseller->markup_rate, 2), '0'), '.') . '%' : '—' }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="text-muted">Joined</span>
                                <strong>{{ $reseller->created_at->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
