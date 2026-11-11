@extends('layouts.admin.app')
@section('title', 'Products')
@section('panel_content')
<style>
    .admin-catalog{--ac-navy:#2a3582;--ac-orange:#fd6801}.admin-catalog .catalog-head{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}.admin-catalog .catalog-head h3{color:var(--ac-navy);font-weight:750;margin:0}.admin-catalog .catalog-card{border:1px solid #e9ebf2;border-radius:15px;box-shadow:0 8px 28px rgba(35,47,103,.06)}.admin-catalog .btn-ac{background:var(--ac-orange);border-color:var(--ac-orange);color:#fff;font-weight:650;border-radius:9px}.admin-catalog .table thead th{white-space:nowrap;color:var(--ac-navy);font-size:13px}.admin-catalog .product-thumb{width:48px;height:48px;border-radius:9px;object-fit:cover;background:#f3f4f8}.admin-catalog .status-pill{display:inline-block;border-radius:20px;padding:4px 10px;background:#fff4e9;color:#a84b00;font-size:12px;font-weight:650}
    @media(max-width:575px){.admin-catalog .catalog-head{align-items:flex-start;flex-direction:column}.admin-catalog .catalog-head .btn{width:100%}}
</style>
<div class="admin-catalog">
    <div class="catalog-head"><div><h3>Products</h3><p class="text-muted mb-0">Manage products created for the marketplace.</p></div><a class="btn btn-ac" href="{{ route('admin.products.products.create') }}"><i class="bx bx-plus"></i> Add product</a></div>
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@endif
    <div class="card catalog-card"><div class="card-body p-3 p-lg-4"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><strong style="color:#2a3582">Product catalog</strong><div class="small text-muted">{{ $products->total() }} products</div></div></div>
        <div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Product</th><th>Category</th><th>Brand</th><th>Price</th><th>Status</th><th>Added</th></tr></thead><tbody>
        @forelse($products as $product)
            <tr><td><div class="d-flex align-items-center gap-2">@if($product->thumbnail)<img class="product-thumb" src="{{ asset('storage/'.$product->thumbnail) }}" alt="">@else<div class="product-thumb d-grid place-items-center text-muted"><i class="bx bx-image"></i></div>@endif<div><strong>{{ $product->name }}</strong><div class="small text-muted">{{ $product->sku ?: 'No SKU' }}</div></div></div></td><td>{{ $product->category?->name ?? '—' }}@if($product->subCategory)<div class="small text-muted">{{ $product->subCategory->name }}</div>@endif</td><td>{{ $product->brand?->name ?? '—' }}</td><td>৳ {{ number_format($product->discount_price ?: $product->price, 2) }}</td><td><span class="status-pill">{{ ucfirst($product->status) }}</span></td><td>{{ $product->created_at?->format('d M Y') }}</td></tr>
        @empty<tr><td colspan="6" class="text-center py-5"><div class="mb-2 text-muted"><i class="bx bx-package" style="font-size:34px"></i></div><strong>No products yet</strong><p class="text-muted mb-3">Add the first product to start building your catalog.</p><a class="btn btn-ac" href="{{ route('admin.products.products.create') }}">Add product</a></td></tr>@endforelse
        </tbody></table></div><div class="mt-3">{{ $products->links() }}</div>
    </div></div>
</div>
@endsection
