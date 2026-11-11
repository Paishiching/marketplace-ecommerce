@extends('layouts.dropshipping.app')

@section('title', 'Dropshipping products')

@section('panel_content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><h3 class="mb-1">My products</h3><p class="text-secondary mb-0">Supplier items assigned to your dropshipping catalog.</p></div>
    <a class="btn btn-primary" href="{{ route('dropshipping.products.create') }}"><i class="bx bx-plus"></i> Add product</a>
</div>
@if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card"><div class="card-body">
    <form method="GET" class="row g-2 mb-3"><div class="col-sm-8 col-md-5"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search product or SKU"></div><div class="col-auto"><button class="btn btn-outline-primary">Search</button></div></form>
    <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Supplier product</th><th>Supplier</th><th>Base price</th><th>Your markup</th><th>Listing price</th><th>Status</th><th>Customer link</th><th></th></tr></thead><tbody>
        @forelse ($products as $listing)
            @php($supplierProduct = $listing->supplierProduct)
            <tr>
                <td><strong>{{ $supplierProduct->name ?? 'Product unavailable' }}</strong><div class="small text-muted">{{ $supplierProduct->sku ?? '' }}</div></td>
                <td>{{ $supplierProduct->supplier?->company_name ?? 'Supplier' }}</td>
                <td>৳{{ number_format((float) ($supplierProduct->base_price ?? 0), 2) }}</td>
                <td>৳{{ number_format((float) $listing->markup_price, 2) }}</td>
                <td>৳{{ number_format((float) ($supplierProduct->base_price ?? 0) + (float) $listing->markup_price, 2) }}</td>
                <td><span class="badge text-bg-{{ $listing->is_active ? 'success' : 'secondary' }}">{{ $listing->is_active ? 'Active' : 'Paused' }}</span></td>
                <td><a class="btn btn-sm btn-outline-primary" href="{{ route('dropship-products.show', $listing) }}" target="_blank" rel="noopener">Open</a></td>
                <td class="text-end"><form class="d-inline" method="POST" action="{{ route('dropshipping.products.toggle', $listing) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-secondary">{{ $listing->is_active ? 'Pause' : 'Activate' }}</button></form> <form class="d-inline" method="POST" action="{{ route('dropshipping.products.destroy', $listing) }}" onsubmit="return confirm('Remove this product from your catalog?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Remove</button></form></td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-secondary py-5">No catalog products yet. Add a product from an approved supplier to get started.</td></tr>
        @endforelse
    </tbody></table></div>
    {{ $products->links() }}
</div></div>
@endsection
