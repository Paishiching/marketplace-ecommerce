@extends('layouts.frontend.app')

@section('title', 'My dropshipping order requests')

@section('content')
<section class="py-5" style="background:#f5f7fb;min-height:60vh"><div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4"><div><h1 class="h2 fw-bold mb-1">My order requests</h1><p class="text-secondary mb-0">Track requests placed with dropshipping sellers.</p></div><a href="{{ route('dropshippings') }}" class="btn btn-outline-primary">Browse dropshipping</a></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Reference</th><th>Product</th><th>Seller</th><th>Supplier</th><th>Quantity</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody>
        @forelse ($orders as $order)
            <tr><td>DSP-{{ $order->id }}</td><td>{{ $order->items->pluck('product_name')->join(', ') }}</td><td>{{ $order->dropshipper?->business_name ?? 'Seller' }}</td><td>{{ $order->supplier?->company_name ?? 'Supplier' }}</td><td>{{ number_format((int) $order->items->sum('quantity')) }}</td><td>BDT {{ number_format((float) $order->sales_total, 2) }}</td><td><span class="badge text-bg-light">{{ ucfirst($order->status) }}</span></td><td>{{ $order->created_at?->format('d M Y') }}</td></tr>
        @empty
            <tr><td colspan="8" class="text-center text-secondary py-5">You have not sent any dropshipping order requests yet.</td></tr>
        @endforelse
    </tbody></table></div>{{ $orders->links() }}</div></div>
</div></section>
@endsection
