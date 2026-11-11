@extends('layouts.superadmin.app')

@section('title', 'Zone Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.shipping-zones.index') }}">Shipping Zones</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $zone->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('superadmin.shipping-zones.edit', $zone) }}" class="btn btn-primary">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('superadmin.shipping-zones.index') }}" class="btn btn-light">Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Zone Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th style="width:180px;">Name</th>
                                    <td class="fw-bold">{{ $zone->name }}</td>
                                </tr>
                                <tr>
                                    <th>Regions</th>
                                    <td>
                                        @if (!empty($zone->regions))
                                            @foreach ($zone->regions as $region)
                                                <span class="badge bg-light text-dark border">{{ $region }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">কোনো region সেট করা নেই।</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($zone->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $zone->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Shipping Rates ({{ $zone->shippingRates->count() }})</h6>
                            <div class="table-responsive">
                                <table class="table align-middle table-hover mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>Created</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($zone->shippingRates as $rate)
                                        <tr>
                                            <td class="fw-bold">{{ $rate->name }}</td>
                                            <td>{{ number_format($rate->rate, 2) }}</td>
                                            <td class="small text-muted">{{ $rate->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">
                                                এই zone এ কোনো rate যোগ করা হয়নি।
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body p-4 text-center">
                            <i class="bx bx-map-alt fs-1 text-primary"></i>
                            <h4 class="mt-2 mb-0">{{ $zone->shippingRates->count() }}</h4>
                            <p class="text-secondary mb-0">Total Rates</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
