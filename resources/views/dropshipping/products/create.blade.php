@extends('layouts.dropshipping.app')

@section('title', 'Add dropshipping product')

@section('panel_content')
<div class="mb-4"><h3 class="mb-1">Add a supplier product</h3><p class="text-secondary mb-0">Choose an approved supplier product and set your per-unit markup.</p></div>
<div class="card"><div class="card-body p-4">
    @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    @if ($availableProducts->isEmpty())
        <div class="alert alert-info mb-0">There are no approved supplier products available at the moment.</div>
    @else
        <form method="POST" action="{{ route('dropshipping.products.store') }}">@csrf
            <div class="mb-3"><label class="form-label" for="supplier_product_id">Supplier product</label><select class="form-select" id="supplier_product_id" name="supplier_product_id" required><option value="">Choose a product</option>@foreach ($availableProducts as $product)<option value="{{ $product->id }}" @selected(old('supplier_product_id') == $product->id)>{{ $product->name }}{{ $product->sku ? ' · ' . $product->sku : '' }} — {{ $product->supplier?->company_name }} (base ৳{{ number_format((float) $product->base_price, 2) }})</option>@endforeach</select></div>
            <div class="mb-4"><label class="form-label" for="markup_price">Markup per unit (৳)</label><input class="form-control" id="markup_price" name="markup_price" type="number" min="0" step="0.01" value="{{ old('markup_price', '0.00') }}" required><div class="form-text">Your listing price is the supplier base price plus this markup.</div></div>
            <button class="btn btn-primary" type="submit">Add to catalog</button> <a class="btn btn-light" href="{{ route('dropshipping.products.index') }}">Cancel</a>
        </form>
    @endif
</div></div>
@endsection
