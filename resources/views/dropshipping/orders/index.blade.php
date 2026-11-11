@extends('layouts.dropshipping.app')

@section('title', 'Dropshipping orders')

@section('panel_content')
<div class="mb-4"><h3 class="mb-1">My orders</h3><p class="text-secondary mb-0">Customer requests for your active product links.</p></div>
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Order / Product</th><th>Customer</th><th>Supplier</th><th>Quantity</th><th>Status</th><th>Sales</th><th>Cost</th><th>Profit</th><th>Date</th></tr></thead><tbody>
    @forelse ($orders as $order)
        <tr>
            <td><strong>{{ $order->sourceOrder?->order_number ? '#' . $order->sourceOrder->order_number : 'DSP-' . $order->id }}</strong><div class="small text-muted">{{ $order->items->pluck('product_name')->join(', ') }}</div></td>
            <td>{{ $order->customer?->user?->name ?? 'Customer' }}<div class="small text-muted">{{ $order->customer?->user?->email }}</div></td>
            <td>{{ $order->supplier?->company_name ?? 'Supplier' }}</td>
            <td>{{ number_format((int) $order->items->sum('quantity')) }}</td>
            <td><span class="badge text-bg-light">{{ ucfirst($order->status) }}</span></td>
            <td>BDT {{ number_format((float) $order->sales_total, 2) }}</td>
            <td>BDT {{ number_format((float) $order->total_cost, 2) }}</td>
            <td>BDT {{ number_format((float) $order->profit, 2) }}</td>
            <td>{{ $order->created_at?->format('d M Y') }}</td>
        </tr>
    @empty
        <tr><td colspan="9" class="text-center text-secondary py-5">Customer order requests for your active product links will appear here.</td></tr>
    @endforelse
</tbody></table></div>{{ $orders->links() }}</div></div>
@endsection
