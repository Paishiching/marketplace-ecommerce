@extends('layouts.superadmin.app')

@section('title', 'Tracking History')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.shipment-tracking.index') }}">Shipment Tracking</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $shipment->tracking_number ?? '#' . $shipment->id }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.shipment-tracking.index') }}" class="btn btn-light">Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Shipment Info</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th style="width:140px;">Tracking No.</th>
                                    <td class="fw-bold">{{ $shipment->tracking_number ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Order</th>
                                    <td>
                                        @if ($shipment->order)
                                            #{{ $shipment->order->id }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Courier</th>
                                    <td>{{ $shipment->courier->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                <tr>
                                    <th>Shipped At</th>
                                    <td>{{ $shipment->shipped_at ? $shipment->shipped_at->format('d M Y, h:i A') : '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Delivered At</th>
                                    <td>{{ $shipment->delivered_at ? $shipment->delivered_at->format('d M Y, h:i A') : '—' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <h6 class="mb-3">Tracking Timeline</h6>

                            @forelse ($events as $event)
                                <div class="d-flex mb-4 {{ !$loop->last ? 'border-bottom pb-4' : '' }}">
                                    <div class="me-3">
                                        @php
                                            $statusColors = [
                                                'picked_up'       => 'info',
                                                'in_transit'      => 'primary',
                                                'out_for_delivery'=> 'warning',
                                                'delivered'       => 'success',
                                                'failed'          => 'danger',
                                            ];
                                            $color = $statusColors[$event->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }} rounded-circle p-2">
                                            <i class="bx bx-package"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ ucfirst(str_replace('_', ' ', $event->status)) }}</h6>
                                        @if ($event->location)
                                            <p class="mb-1 text-secondary"><i class="bx bx-map-pin"></i> {{ $event->location }}</p>
                                        @endif
                                        <small class="text-muted">{{ $event->event_time->format('d M Y, h:i A') }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <i class="bx bx-time fs-1 d-block mb-2"></i>
                                    এই shipment এর জন্য এখনো কোনো tracking event যোগ করা হয়নি।
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
