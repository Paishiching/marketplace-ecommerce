@extends('layouts.frontend.app')

@section('title', $wholesaleProduct->product->name . ' wholesale')

@section('content')
<section class="py-5" style="background:#f5f7fb;min-height:60vh"><div class="container">
    <div class="mb-3"><a href="{{ route('wholesales') }}" class="text-decoration-none">← Wholesale products</a></div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="card-body p-4 p-lg-5"><div class="row g-4 align-items-start">
        <div class="col-12 col-lg-5">@if ($wholesaleProduct->product->thumbnail)<img src="{{ asset('storage/' . $wholesaleProduct->product->thumbnail) }}" class="img-fluid rounded bg-light w-100" style="max-height:420px;object-fit:contain" alt="{{ $wholesaleProduct->product->name }}">@else<div class="d-flex align-items-center justify-content-center bg-light rounded" style="height:320px"><i class="bx bx-package fs-1"></i></div>@endif</div>
        <div class="col-12 col-lg-7"><div class="small text-muted mb-2">{{ $wholesaleProduct->wholesaler?->business_name ?? 'Marketplace wholesale' }}</div><h1 class="h2 fw-bold">{{ $wholesaleProduct->product->name }}</h1><p class="text-muted">{{ $wholesaleProduct->product->short_description }}</p><div class="fs-4 fw-bold mb-2">৳{{ number_format((float) ($wholesaleProduct->product->discount_price ?: $wholesaleProduct->product->price), 2) }} <span class="fs-6 fw-normal text-muted">starting unit price</span></div><p class="mb-4">Minimum order: <strong>{{ number_format((int) ($wholesaleProduct->minimumOrderQuantity?->moq ?? 1)) }}</strong></p>
            @if ($wholesaleProduct->wholesaleTiers->isNotEmpty())
                <h2 class="h6 fw-bold">Quantity pricing</h2><div class="table-responsive mb-4"><table class="table table-sm"><thead><tr><th>Quantity</th><th>Unit price</th></tr></thead><tbody>@foreach ($wholesaleProduct->wholesaleTiers->sortBy('min_quantity') as $tier)<tr><td>{{ number_format($tier->min_quantity) }}–{{ $tier->max_quantity ? number_format($tier->max_quantity) : 'unlimited' }}</td><td>৳{{ number_format((float) ($tier->wholesalePrice?->unit_price ?? 0), 2) }}</td></tr>@endforeach</tbody></table></div>
            @endif
            @auth
                <form method="POST" action="{{ route('wholesales.orders.store', $wholesaleProduct) }}" class="row g-3 align-items-end">@csrf<div class="col-12 col-sm-5"><label class="form-label" for="quantity">Order quantity</label><input class="form-control" id="quantity" name="quantity" type="number" min="{{ max(1, (int) ($wholesaleProduct->minimumOrderQuantity?->moq ?? 1)) }}" value="{{ old('quantity', max(1, (int) ($wholesaleProduct->minimumOrderQuantity?->moq ?? 1))) }}" required></div><div class="col-12 col-sm-7"><button class="btn btn-primary btn-lg w-100">Request bulk order</button></div></form>
            @else
                <a class="btn btn-primary btn-lg" href="{{ route('otp.login') }}">Sign in to request a bulk order</a>
            @endauth
        </div>
    </div></div></div>
</div></section>
@endsection
