@extends('layouts.superadmin.app')

@section('title', 'Inventory')

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
                            <li class="breadcrumb-item active" aria-current="page">Inventory</li>
                        </ol>
                    </nav>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">

                    <form method="GET" action="{{ route('vendor.products.inventories.index') }}" class="row g-2 mb-4">
                        <div class="col-lg-4">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Product name or SKU">
                        </div>
                        <div class="col-lg-3">
                            <select name="stock" class="form-select">
                                <option value="">All stock</option>
                                <option value="low" @selected(request('stock') === 'low')>Low stock (≤ {{ $lowStock }})</option>
                            </select>
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
                            <a href="{{ route('vendor.products.inventories.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width:70px;">Image</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Unit</th>
                                <th>SKU</th>
                                <th class="text-end">Price</th>
                                <th style="width:230px;">Stock</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                @php
                                    $badge = ['published' => 'success', 'pending' => 'warning', 'rejected' => 'danger', 'draft' => 'secondary'][$product->status] ?? 'secondary';
                                    $rows  = max($product->productVariants->count(), 1);
                                @endphp

                                @forelse ($product->productVariants as $i => $variant)
                                    <tr>
                                        @if ($i === 0)
                                            <td rowspan="{{ $rows }}">
                                                @if ($product->thumbnail)
                                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" width="50" height="50" style="object-fit:cover;border-radius:6px;" alt="">
                                                @endif
                                            </td>
                                            <td rowspan="{{ $rows }}">
                                                <div class="fw-semibold">{{ $product->name }}</div>
                                                <div class="text-muted small">#{{ $product->id }}</div>
                                            </td>
                                            <td rowspan="{{ $rows }}">
                                                <div class="badge rounded-pill text-{{ $badge }} bg-light-{{ $badge }} p-2 text-uppercase px-3">{{ $product->status }}</div>
                                            </td>
                                        @endif
                                        <td>{{ rtrim(rtrim((string) $variant->unit_value, '0'), '.') }} {{ $variant->unit_type }}</td>
                                        <td>{{ $variant->sku ?: '—' }}</td>
                                        <td class="text-end">৳{{ number_format($variant->price, 2) }}</td>
                                        <td>
                                            <form action="{{ route('vendor.products.inventories.update', $variant->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" min="0" name="stock_quantity" value="{{ $variant->stock_quantity }}"
                                                       class="form-control form-control-sm {{ $variant->stock_quantity <= $lowStock ? 'border-danger' : '' }}" style="width:100px;">
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                @if ($variant->stock_quantity <= $lowStock)
                                                    <span class="badge bg-danger">Low</span>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            @if ($product->thumbnail)
                                                <img src="{{ asset('storage/' . $product->thumbnail) }}" width="50" height="50" style="object-fit:cover;border-radius:6px;" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <div class="text-muted small">#{{ $product->id }}</div>
                                        </td>
                                        <td>
                                            <div class="badge rounded-pill text-{{ $badge }} bg-light-{{ $badge }} p-2 text-uppercase px-3">{{ $product->status }}</div>
                                        </td>
                                        <td colspan="4" class="text-muted">
                                            Ei product-e stock variant nai.
                                            <a href="{{ route('vendor.products.products.edit', $product->id) }}">Edit kore stock dian</a>
                                        </td>
                                    </tr>
                                @endforelse
                            @empty
                                <tr><td colspan="7" class="text-center py-4">No products found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection