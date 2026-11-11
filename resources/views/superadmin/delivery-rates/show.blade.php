@extends('layouts.superadmin.app')

@section('title', 'Rate Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.delivery-rates.index') }}">Delivery Rates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $rate->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('superadmin.delivery-rates.edit', $rate) }}" class="btn btn-primary">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('superadmin.delivery-rates.index') }}" class="btn btn-light">Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Rate Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th style="width:180px;">Name</th>
                                    <td class="fw-bold">{{ $rate->name }}</td>
                                </tr>
                                <tr>
                                    <th>Zone</th>
                                    <td>
                                        @if ($rate->shippingZone)
                                            <a href="{{ route('superadmin.shipping-zones.show', $rate->shippingZone) }}">{{ $rate->shippingZone->name }}</a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Rate</th>
                                    <td>৳{{ number_format($rate->rate, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $rate->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body p-4 text-center">
                            <i class="bx bx-purchase-tag-alt fs-1 text-primary"></i>
                            <h4 class="mt-2 mb-0">৳{{ number_format($rate->rate, 2) }}</h4>
                            <p class="text-secondary mb-0">Current Rate</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
