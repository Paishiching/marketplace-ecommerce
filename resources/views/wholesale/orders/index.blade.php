@extends('layouts.wholesale.app')

@section('title', 'Wholesale orders')

@section('panel_content')
<div class="mb-4"><h3 class="mb-1">Bulk orders</h3><p class="text-secondary mb-0">Orders placed for products owned by your wholesale account.</p></div>
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Order</th><th>Customer</th><th>Product</th><th>Quantity</th><th>Total</th><th>Status</th><th>Date</th></tr></thead><tbody>
    @forelse ($orders as $order)
        <tr><td>#{{ $order->id }}</td><td>{{ $order->customer?->user?->name ?? 'Customer' }}<div class="small text-muted">{{ $order->customer?->user?->email }}</div></td><td>{{ $order->wholesaleProduct?->product?->name ?? 'Product unavailable' }}</td><td>{{ number_format((int) $order->quantity) }}</td><td>BDT {{ number_format((float) $order->total_price, 2) }}</td><td><span class="badge text-bg-light">{{ ucfirst($order->status) }}</span></td><td>{{ $order->created_at?->format('d M Y') }}</td></tr>
    @empty
        <tr><td colspan="7" class="text-center text-secondary py-5">No bulk orders have been placed for your listings yet.</td></tr>
    @endforelse
</tbody></table></div>{{ $orders->links() }}</div></div>
@endsection

