@extends('layouts.superadmin.app')

@section('title', 'Shipments')

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
                            <li class="breadcrumb-item active" aria-current="page">Shipments</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            <div class="card">
                <div class="card-body">

                    <form method="GET" action="{{ route('vendor.orders.shipments.index') }}" class="row g-2 mb-4">
                        <div class="col-lg-4">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Order no, tracking, consignment">
                        </div>
                        <div class="col-lg-3">
                            <select name="status" class="form-select">
                                <option value="">All status</option>
                                @foreach (['in_transit' => 'In Transit', 'delivered' => 'Delivered', 'returned' => 'Returned', 'cancelled' => 'Cancelled'] as $val => $label)
                                    <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
                            <a href="{{ route('vendor.orders.shipments.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Order#</th>
                                <th>Customer</th>
                                <th>Courier</th>
                                <th>Tracking</th>
                                <th>Status</th>
                                <th>Courier Status</th>
                                <th>Shipped</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($shipments as $shipment)
                                @php
                                    $order = $orders[$shipment->order_id] ?? null;
                                    $color = match ($shipment->status) {
                                        'delivered'          => 'success',
                                        'returned', 'cancelled' => 'danger',
                                        default              => 'info',
                                    };
                                @endphp
                                <tr>
                                    <td>#{{ $order->order_number ?? $shipment->order_id }}</td>
                                    <td>
                                        {{ $order->name ?? '—' }}
                                        <div class="text-muted small">{{ $order->phone ?? '' }}</div>
                                    </td>
                                    <td>{{ $shipment->courier->name ?? '—' }}</td>
                                    <td>
                                        @if (method_exists($shipment, 'trackingLink') && $shipment->trackingLink())
                                            <a href="{{ $shipment->trackingLink() }}" target="_blank" rel="noopener">{{ $shipment->tracking_number }}</a>
                                        @else
                                            {{ $shipment->tracking_number ?: '—' }}
                                        @endif
                                        @if ($shipment->consignment_id)
                                            <div class="text-muted small">#{{ $shipment->consignment_id }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="badge rounded-pill text-{{ $color }} bg-light-{{ $color }} p-2 text-uppercase px-3">
                                            {{ str_replace('_', ' ', $shipment->status) }}
                                        </div>
                                    </td>
                                    <td class="text-capitalize">{{ str_replace('_', ' ', $shipment->courier_status ?? '—') }}</td>
                                    <td>{{ $shipment->shipped_at ? \Illuminate\Support\Carbon::parse($shipment->shipped_at)->format('M d, Y h:i A') : '—' }}</td>
                                    <td>
                                        <a href="{{ route('vendor.orders.orders.show', $shipment->order_id) }}" class="btn btn-primary btn-sm radius-30 px-3">Order</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No shipments found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $shipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection