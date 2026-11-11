@extends('layouts.superadmin.app')

@section('title', 'Shipment Tracking')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shipment Tracking</li>
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- FILTERS --}}
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('superadmin.shipment-tracking.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label mb-1">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Tracking number..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary flex-fill" type="submit"><i class="bx bx-filter-alt"></i> Search</button>
                            <a href="{{ route('superadmin.shipment-tracking.index') }}" class="btn btn-light">Reset</a>
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
                                <th>ID#</th>
                                <th>Tracking No.</th>
                                <th>Courier</th>
                                <th>Status</th>
                                <th>Events</th>
                                <th>Shipped</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($shipments as $shipment)
                                <tr>
                                    <td>#{{ $shipment->id }}</td>
                                    <td class="fw-bold">{{ $shipment->tracking_number ?? '—' }}</td>
                                    <td>{{ $shipment->courier->name ?? '—' }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'picked_up'       => 'info',
                                                'in_transit'      => 'primary',
                                                'out_for_delivery'=> 'warning',
                                                'delivered'       => 'success',
                                                'failed'          => 'danger',
                                            ];
                                            $color = $statusColors[$shipment->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $shipment->status)) }}</span>
                                    </td>
                                    <td>{{ number_format($shipment->tracking_events_count) }}</td>
                                    <td class="small text-muted">
                                        {{ $shipment->shipped_at ? $shipment->shipped_at->format('d M Y') : '—' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('superadmin.shipment-tracking.show', $shipment) }}" class="btn btn-sm btn-outline-info" title="View Tracking History">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-package fs-1 d-block mb-2"></i>
                                        কোনো shipment পাওয়া যায়নি।
                                    </td>
                                </tr>
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
