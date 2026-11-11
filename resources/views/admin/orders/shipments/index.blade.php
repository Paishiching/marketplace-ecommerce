@extends(auth()->user()->hasRole('superadmin') ? 'layouts.superadmin.panel' : 'layouts.admin.app')
@section('title', 'Delivery transport')
@section('panel_content')
@php($transportCreateRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.create' : 'admin.orders.shipments.create')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3"><div><h3 class="mb-1">Delivery transport</h3><p class="text-muted mb-0">Driver, vehicle and expected arrival details for customer orders.</p></div><a href="{{ route($transportCreateRoute) }}" class="btn btn-primary"><i class="bx bx-plus"></i> New transport entry</a></div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Order / Party</th><th>Driver</th><th>Mobile</th><th>Vehicle</th><th>Owner / Agency</th><th>Expected arrival</th><th>Status</th></tr></thead><tbody>
@forelse($shipments as $shipment)@php($order=$shipment->order)
<tr><td><strong>{{ $order?->order_number ?? 'Order #'.$shipment->order_id }}</strong><div class="small text-muted">Party #{{ $order?->customer_id ?? '—' }} · {{ $order?->name ?? 'Customer' }}</div></td><td>{{ $shipment->driver_name }}</td><td>{{ $shipment->driver_phone }}</td><td>{{ $shipment->vehicle_number }}</td><td>{{ $shipment->vehicle_owner }}</td><td>{{ $shipment->expected_arrival_at?->format('d M Y') ?? '—' }}</td><td><span class="badge bg-light text-dark">{{ ucfirst($shipment->status) }}</span></td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-5">No delivery transport entries yet.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $shipments->links() }}</div></div></div>
@endsection
