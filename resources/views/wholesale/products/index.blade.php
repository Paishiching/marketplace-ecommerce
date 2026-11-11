@extends('layouts.wholesale.app')

@section('title', 'Wholesale products')

@section('panel_content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"><div><h3 class="mb-1">My wholesale products</h3><p class="text-secondary mb-0">Products listed under your wholesale account.</p></div><a class="btn btn-primary" href="{{ route('wholesale.products.create') }}"><i class="bx bx-plus"></i> Add product</a></div>
@if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Product</th><th>Base price</th><th>Price tiers</th><th>Bulk orders</th><th>Status</th><th></th></tr></thead><tbody>
    @forelse ($products as $listing)
        <tr><td><strong>{{ $listing->product?->name ?? 'Product unavailable' }}</strong><div class="small text-muted">{{ $listing->product?->sku }}</div></td><td>৳{{ number_format((float) ($listing->product?->price ?? 0), 2) }}</td><td>{{ $listing->wholesale_tiers_count }}</td><td>{{ $listing->bulk_orders_count }}</td><td><span class="badge text-bg-{{ $listing->is_wholesale_enabled ? 'success' : 'secondary' }}">{{ $listing->is_wholesale_enabled ? 'Published' : 'Paused' }}</span></td><td class="text-end"><form class="d-inline" method="POST" action="{{ route('wholesale.products.toggle', $listing) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-secondary">{{ $listing->is_wholesale_enabled ? 'Pause' : 'Publish' }}</button></form> <form class="d-inline" method="POST" action="{{ route('wholesale.products.destroy', $listing) }}" onsubmit="return confirm('Remove this listing?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Remove</button></form></td></tr>
    @empty
        <tr><td colspan="6" class="text-center text-secondary py-5">You have not added any wholesale products yet.</td></tr>
    @endforelse
</tbody></table></div>{{ $products->links() }}</div></div>
@endsection
