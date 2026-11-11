@extends('layouts.wholesale.app')

@section('title', 'Wholesale price tiers')

@section('panel_content')
<div class="mb-4"><h3 class="mb-1">Price tiers</h3><p class="text-secondary mb-0">Set unit prices by minimum order quantity.</p></div>
@if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<div class="card mb-4"><div class="card-body p-4"><h5 class="mb-3">Add a price tier</h5>
    @if ($products->isEmpty())<div class="text-secondary">Add a wholesale product before creating price tiers.</div>
    @else
        <form class="row g-3" method="POST" action="{{ route('wholesale.tiers.store') }}">@csrf
            <div class="col-12 col-lg-4"><label class="form-label" for="wholesale_product_id">Product</label><select class="form-select" name="wholesale_product_id" id="wholesale_product_id" required><option value="">Choose a product</option>@foreach ($products as $product)<option value="{{ $product->id }}">{{ $product->product?->name }}</option>@endforeach</select></div>
            <div class="col-6 col-lg-2"><label class="form-label" for="min_quantity">Minimum quantity</label><input class="form-control" type="number" min="1" name="min_quantity" id="min_quantity" value="{{ old('min_quantity', 1) }}" required></div>
            <div class="col-6 col-lg-2"><label class="form-label" for="max_quantity">Maximum quantity</label><input class="form-control" type="number" min="1" name="max_quantity" id="max_quantity" value="{{ old('max_quantity') }}"><div class="form-text">Leave blank for no limit.</div></div>
            <div class="col-8 col-lg-2"><label class="form-label" for="unit_price">Unit price (৳)</label><input class="form-control" type="number" min="0.01" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" required></div>
            <div class="col-4 col-lg-2 d-flex align-items-end"><button class="btn btn-primary w-100">Save tier</button></div>
        </form>
    @endif
</div></div>
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Product</th><th>Quantity range</th><th>Unit price</th><th></th></tr></thead><tbody>
    @forelse ($tiers as $tier)
        <tr><td>{{ $tier->wholesaleProduct?->product?->name ?? 'Product unavailable' }}</td><td>{{ number_format($tier->min_quantity) }} – {{ $tier->max_quantity ? number_format($tier->max_quantity) : 'unlimited' }}</td><td>৳{{ number_format((float) ($tier->wholesalePrice?->unit_price ?? 0), 2) }}</td><td class="text-end"><form method="POST" action="{{ route('wholesale.tiers.destroy', $tier) }}" onsubmit="return confirm('Remove this price tier?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Remove</button></form></td></tr>
    @empty
        <tr><td colspan="4" class="text-center text-secondary py-5">No price tiers yet.</td></tr>
    @endforelse
</tbody></table></div>{{ $tiers->links() }}</div></div>
@endsection
