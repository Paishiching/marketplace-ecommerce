@extends('layouts.superadmin.app')

@section('title', 'Variants')

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Catalog</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Variants</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('vendor.products.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Add Product
                    </a>
                </div>
            </div>

            @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-0">Product Variants</h5>
                    <hr/>

                    <form method="GET" action="{{ route('vendor.products.variants') }}" class="row g-2 mb-4">
                        <div class="col-lg-5">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Product name or SKU">
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Search</button>
                            <a href="{{ route('vendor.products.variants') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    @forelse ($products as $product)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" width="50" height="50" style="object-fit:cover;border-radius:6px;" alt="">
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                    <div class="text-muted small">#{{ $product->id }} &middot; {{ $product->sku ?: 'No SKU' }}</div>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('vendor.products.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-edit"></i> Edit Variants
                                    </a>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <div class="small text-muted mb-1">Colors</div>
                                    @forelse ($product->colorValues as $c)
                                        <span class="badge bg-light text-dark border me-1 mb-1 p-2">{{ $c->value }}</span>
                                    @empty
                                        <span class="text-muted small">—</span>
                                    @endforelse
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted mb-1">Sizes</div>
                                    @forelse ($product->sizeValues as $s)
                                        <span class="badge bg-light text-dark border me-1 mb-1 p-2">{{ $s->value }}</span>
                                    @empty
                                        <span class="text-muted small">—</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Unit</th>
                                        <th>SKU</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Stock</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($product->productVariants as $v)
                                        <tr>
                                            <td>{{ rtrim(rtrim((string) $v->unit_value, '0'), '.') }} {{ $v->unit_type }}</td>
                                            <td>{{ $v->sku ?: '—' }}</td>
                                            <td class="text-end">৳{{ number_format($v->price, 2) }}</td>
                                            <td class="text-end">
                                                <span class="{{ $v->stock_quantity <= 5 ? 'text-danger fw-bold' : '' }}">{{ $v->stock_quantity }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-muted text-center">Ei product-e unit variant nai.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Kono product nai. <a href="{{ route('vendor.products.products.create') }}">Product add korun</a>.</p>
                    @endforelse

                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection