@extends('layouts.superadmin.app')

@section('title', 'Tracking')

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sales</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tracking</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('vendor.orders.trackings') }}" class="row g-2 mb-4">
                        <div class="col-lg-5">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Order no, tracking, consignment">
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Search</button>
                            <a href="{{ route('vendor.orders.trackings') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    @forelse ($shipments as $shipment)
                        @php
                            $order  = $orders[$shipment->order_id] ?? null;
                            $done   = $shipment->status === 'delivered';
                            $failed = in_array($shipment->status, ['returned', 'cancelled'], true);
                            $color  = $done ? 'success' : ($failed ? 'danger' : 'info');
                        @endphp
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <h6 class="mb-0">Order #{{ $order->order_number ?? $shipment->order_id }}</h6>
                                <span class="text-muted small">{{ $order->name ?? '' }}</span>
                                <div class="ms-auto badge rounded-pill text-{{ $color }} bg-light-{{ $color }} p-2 text-uppercase px-3">
                                    {{ str_replace('_', ' ', $shipment->status) }}
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <div class="text-muted small">Courier</div>
                                    {{ $shipment->courier->name ?? '—' }}
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted small">Tracking / Consignment</div>
                                    @if (method_exists($shipment, 'trackingLink') && $shipment->trackingLink())
                                        <a href="{{ $shipment->trackingLink() }}" target="_blank" rel="noopener">{{ $shipment->tracking_number }}</a>
                                    @else
                                        {{ $shipment->tracking_number ?: '—' }}
                                    @endif
                                    @if ($shipment->consignment_id)
                                        <span class="text-muted small">#{{ $shipment->consignment_id }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted small">Courier Status</div>
                                    <span class="text-capitalize">{{ str_replace('_', ' ', $shipment->courier_status ?? '—') }}</span>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-4 mt-3 small">
                                <div>
                                    <i class="bx bxs-circle text-success"></i> Shipped:
                                    {{ $shipment->shipped_at ? \Illuminate\Support\Carbon::parse($shipment->shipped_at)->format('M d, Y h:i A') : '—' }}
                                </div>
                                <div>
                                    <i class="bx bxs-circle {{ $done ? 'text-success' : 'text-secondary' }}"></i> Delivered:
                                    {{ $shipment->delivered_at ? \Illuminate\Support\Carbon::parse($shipment->delivered_at)->format('M d, Y h:i A') : 'Pending' }}
                                </div>
                                <div class="text-muted">
                                    Last update: {{ $shipment->last_synced_at ? \Illuminate\Support\Carbon::parse($shipment->last_synced_at)->diffForHumans() : 'never' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Kono shipment nai.</p>
                    @endforelse

                    <div class="mt-3">{{ $shipments->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection