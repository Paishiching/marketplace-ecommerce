@extends('layouts.frontend.app')

@section('title', 'Wholesale products')

@section('content')
<section class="py-5" style="background:#f5f7fb;min-height:60vh"><div class="container">
    <div class="mb-4"><h1 class="h2 fw-bold mb-1">Wholesale products</h1><p class="text-muted mb-0">Bulk pricing from marketplace wholesalers.</p></div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="row g-3">
        @forelse ($products as $listing)
            <div class="col-12 col-sm-6 col-lg-4"><article class="card h-100 border-0 shadow-sm">
                <a class="text-decoration-none text-reset" href="{{ route('wholesales.show', $listing) }}">
                    @if ($listing->product?->thumbnail)<img src="{{ asset('storage/' . $listing->product->thumbnail) }}" class="card-img-top" style="height:220px;object-fit:contain;background:#fff" alt="{{ $listing->product->name }}">@else<div class="d-flex align-items-center justify-content-center bg-light" style="height:220px"><i class="bx bx-package fs-1 text-secondary"></i></div>@endif
                    <div class="card-body"><div class="small text-muted mb-2">{{ $listing->wholesaler?->business_name ?? 'Marketplace wholesale' }}</div><h2 class="h5">{{ $listing->product?->name }}</h2><div class="fw-bold">৳{{ number_format((float) ($listing->product?->discount_price ?: $listing->product?->price), 2) }} <span class="small fw-normal text-muted">starting price</span></div><div class="small text-muted mt-2">Minimum order: {{ number_format((int) ($listing->minimumOrderQuantity?->moq ?? 1)) }}</div></div>
                </a>
                <div class="card-body pt-0"><a href="{{ route('wholesales.show', $listing) }}" class="btn btn-outline-primary w-100">View bulk pricing</a></div>
            </article></div>
        @empty
            <div class="col-12"><div class="card border-0 shadow-sm"><div class="card-body text-center py-5"><i class="bx bx-package fs-1 text-secondary"></i><h2 class="h5 mt-3">No wholesale products yet</h2><p class="text-muted mb-0">Check back later for bulk listings.</p></div></div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div></section>
@endsection
