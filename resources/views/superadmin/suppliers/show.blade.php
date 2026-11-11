@extends('layouts.superadmin.app')

@section('title', 'Supplier Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Suppliers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.suppliers.index') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $supplier->company_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('superadmin.suppliers.edit', $supplier->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('superadmin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
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
                            <div class="d-flex align-items-center gap-3">
                                @if ($supplier->logo)
                                    <img src="{{ asset('storage/' . $supplier->logo) }}" alt="{{ $supplier->company_name }}" width="80" height="80" style="object-fit:cover;border-radius:10px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width:80px;height:80px;border-radius:10px;">
                                        <i class="bx bx-buildings fs-2 text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="mb-1">{{ $supplier->company_name }}</h4>
                                    <div class="text-muted small">/{{ $supplier->company_slug }}</div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="text-uppercase text-muted mb-2">Description</h6>
                            <p class="mb-0">{{ $supplier->description ?: 'No description provided.' }}</p>
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
                                    <div class="fw-semibold">{{ $supplier->user->name ?? '—' }}</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="text-muted small">Email</div>
                                    <div class="fw-semibold">{{ $supplier->user->email ?? '—' }}</div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="text-muted small">Phone</div>
                                    <div class="fw-semibold">{{ $supplier->user->phone ?? '—' }}</div>
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

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Status</span>
                                @if ($supplier->status === 'approved')
                                    <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Approved</span>
                                @elseif ($supplier->status === 'suspended')
                                    <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Suspended</span>
                                @else
                                    <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Verified</span>
                                @if ($supplier->is_verified)
                                    <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Yes</span>
                                @else
                                    <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">No</span>
                                @endif
                            </div>

                            @include('superadmin.partials.approval-buttons', [
                                'model'       => $supplier,
                                'routePrefix' => 'superadmin.suppliers',
                            ])
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bx bx-bar-chart-alt-2 text-primary"></i> Overview
                            </h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="text-muted">Joined</span>
                                <strong>{{ $supplier->created_at->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
