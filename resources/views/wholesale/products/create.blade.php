@extends('layouts.wholesale.app')

@section('title', 'Add wholesale product')

@section('panel_content')
<div class="mb-4"><h3 class="mb-1">Add a wholesale product</h3><p class="text-secondary mb-0">Choose a published marketplace product for your own wholesale listing.</p></div>
<div class="card"><div class="card-body p-4">
    @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    @if ($products->isEmpty())<div class="alert alert-info mb-0">No published products are available to add right now.</div>
    @else
        <form method="POST" action="{{ route('wholesale.products.store') }}">@csrf
            <div class="mb-4"><label class="form-label" for="product_id">Marketplace product</label><select class="form-select" name="product_id" id="product_id" required><option value="">Choose a product</option>@foreach ($products as $product)<option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }}{{ $product->sku ? ' · ' . $product->sku : '' }} — ৳{{ number_format((float) $product->price, 2) }}</option>@endforeach</select></div>
            <button type="submit" class="btn btn-primary">Add listing</button> <a class="btn btn-light" href="{{ route('wholesale.products.index') }}">Cancel</a>
        </form>
    @endif
</div></div>
@endsection
