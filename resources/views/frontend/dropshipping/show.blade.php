@extends('layouts.frontend.app')

@section('title', $listing->supplierProduct->name . ' — dropshipping')

@section('content')
<section class="py-5" style="background:#f5f7fb;min-height:60vh">
    <div class="container">
        <a href="{{ route('homes') }}" class="text-decoration-none">← Back to store</a>
        @if (session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
        @if ($errors->any())<div class="alert alert-danger mt-3">{{ $errors->first() }}</div>@endif

        <div class="card border-0 shadow-sm mt-3"><div class="card-body p-4 p-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-12 col-lg-5">
                    @if ($listing->supplierProduct->product?->thumbnail)
                        <img src="{{ asset('storage/' . $listing->supplierProduct->product->thumbnail) }}" class="img-fluid w-100 rounded bg-light" style="max-height:420px;object-fit:contain" alt="{{ $listing->supplierProduct->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height:320px"><i class="bx bx-package fs-1 text-secondary"></i></div>
                    @endif
                </div>
                <div class="col-12 col-lg-7">
                    <p class="text-secondary mb-2">Sold by {{ $listing->dropshipper->business_name }}</p>
                    <h1 class="h2 fw-bold">{{ $listing->supplierProduct->name }}</h1>
                    @if ($listing->supplierProduct->description)<p class="text-secondary">{{ $listing->supplierProduct->description }}</p>@endif
                    <p class="h3 fw-bold mb-1">BDT {{ number_format((float) $listing->supplierProduct->base_price + (float) $listing->markup_price, 2) }}</p>
                    <p class="text-secondary">Minimum order: {{ number_format(max(1, (int) $listing->supplierProduct->moq)) }} units</p>
                    @auth
                        <a class="btn btn-sm btn-outline-primary mb-3" href="{{ route('dropship-products.orders.mine') }}">My order requests</a>
                        <form method="POST" action="{{ route('dropship-products.orders.store', $listing) }}" class="row g-3 align-items-end mt-3">
                            @csrf
                            <div class="col-12 col-sm-5"><label class="form-label" for="quantity">Quantity</label><input class="form-control" id="quantity" name="quantity" type="number" min="{{ max(1, (int) $listing->supplierProduct->moq) }}" value="{{ old('quantity', max(1, (int) $listing->supplierProduct->moq)) }}" required></div>
                            <div class="col-12 col-sm-7"><button class="btn btn-primary btn-lg w-100">Place order request</button></div>
                        </form>
                        <small class="d-block text-secondary mt-2">The seller will contact you to confirm payment and delivery.</small>
                    @else
                        <a class="btn btn-primary btn-lg mt-3" href="{{ route('otp.login') }}">Sign in to order</a>
                    @endauth
                </div>
            </div>
        </div></div>
    </div>
</section>
@endsection
