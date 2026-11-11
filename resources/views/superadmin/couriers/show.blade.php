@extends('layouts.superadmin.app')

@section('title', 'Courier Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.couriers.index') }}">Couriers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $courier->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.couriers.edit', $courier) }}" class="btn btn-primary">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('superadmin.couriers.index') }}" class="btn btn-light">Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="mb-0">{{ $courier->name }}</h4>
                                @if ($courier->status)
                                    <span class="badge bg-success fs-6">Active</span>
                                @else
                                    <span class="badge bg-danger fs-6">Inactive</span>
                                @endif
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Tracking URL</div>
                                    <div>
                                        @if ($courier->tracking_url)
                                            <a href="{{ $courier->tracking_url }}" target="_blank" rel="noopener">{{ $courier->tracking_url }}</a>
                                        @else
                                            <span class="text-muted">Set করা নেই</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Total Shipments</div>
                                    <div class="fs-5 fw-semibold">{{ number_format($courier->shipments_count) }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Added On</div>
                                    <div>{{ $courier->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('superadmin.couriers.edit', $courier) }}" class="btn btn-primary">
                            <i class="bx bx-edit"></i> Edit Courier
                        </a>
                        <form action="{{ route('superadmin.couriers.destroy', $courier) }}" method="POST"
                              onsubmit="return confirm('এই courier টি delete করবেন?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bx bx-trash"></i> Delete Courier
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
