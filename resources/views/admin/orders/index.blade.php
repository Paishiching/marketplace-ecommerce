@extends(auth()->user()->hasRole('superadmin') ? 'layouts.superadmin.panel' : 'layouts.admin.app')
@section('title', 'Orders')
@section('panel_content')
@php($ordersIndexRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.manual-orders.index' : 'admin.orders.orders.index')
@php($ordersCreateRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.manual-orders.create' : 'admin.orders.orders.create')
@php($ordersShowRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.manual-orders.show' : 'admin.orders.orders.show')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div><h3 class="mb-1">Orders</h3><p class="text-muted mb-0">Review website and manually entered orders.</p></div>
    <a href="{{ route($ordersCreateRoute) }}" class="btn btn-primary"><i class="bx bx-plus"></i> New order</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table table-hover align-middle mb-0">
    <thead><tr><th>Order</th><th>Customer</th><th>Phone</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr><td><strong>{{ $order->order_number }}</strong><div class="small text-muted">{{ strtoupper($order->source ?? 'website') }}</div></td>
            <td>{{ $order->name ?: $order->customer?->user?->name ?: 'Customer' }}</td><td>{{ $order->phone }}</td>
            <td>{{ $order->orderItems()->sum('quantity') }}</td><td>৳ {{ number_format($order->total, 2) }}</td>
            <td><span class="badge bg-light text-dark">{{ ucfirst($order->status) }}</span></td><td>{{ $order->created_at?->format('d M Y, g:i A') }}</td>
            <td><a class="btn btn-sm btn-outline-primary" href="{{ route($ordersShowRoute, $order) }}">View</a></td></tr>
    @empty<tr><td colspan="8" class="text-center py-5 text-muted">No orders yet.</td></tr>@endforelse
    </tbody></table></div><div class="mt-3">{{ $orders->links() }}</div></div></div>
@endsection
