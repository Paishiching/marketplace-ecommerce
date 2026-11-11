@extends('layouts.admin.app')
@section('title', 'Categories')
@section('panel_content')
<style>
    .admin-category-list{--ac-navy:#2a3582;--ac-orange:#fd6801}.admin-category-list .catalog-head{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}.admin-category-list h3{color:var(--ac-navy);font-weight:750;margin:0}.admin-category-list .catalog-card{border:1px solid #e9ebf2;border-radius:15px;box-shadow:0 8px 28px rgba(35,47,103,.06)}.admin-category-list .btn-ac{background:var(--ac-orange);border-color:var(--ac-orange);color:#fff;font-weight:650;border-radius:9px}.admin-category-list .badge-active{background:#e9f8ef;color:#207345}.admin-category-list .badge-inactive{background:#f1f2f6;color:#626982}@media(max-width:575px){.admin-category-list .catalog-head{align-items:flex-start;flex-direction:column}.admin-category-list .catalog-head .btn{width:100%}}
</style>
<div class="admin-category-list"><div class="catalog-head"><div><h3>Categories</h3><p class="text-muted mb-0">Organize products into clear, easy-to-browse groups.</p></div><a class="btn btn-ac" href="{{ route('admin.products.categories.create') }}"><i class="bx bx-plus"></i> Add category</a></div>
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@endif
    <div class="card catalog-card"><div class="card-body p-3 p-lg-4"><div class="small text-muted mb-3">{{ $categories->total() }} categories</div><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Category</th><th>Parent category</th><th>Products</th><th>Status</th><th>Created</th></tr></thead><tbody>
        @forelse($categories as $category)<tr><td><strong>{{ $category->name }}</strong><div class="small text-muted">{{ $category->slug }}</div></td><td>{{ $category->parent?->name ?? 'Main category' }}</td><td>{{ $category->products_count }}</td><td><span class="badge {{ $category->status ? 'badge-active' : 'badge-inactive' }}">{{ $category->status ? 'Active' : 'Inactive' }}</span></td><td>{{ $category->created_at?->format('d M Y') }}</td></tr>
        @empty<tr><td colspan="5" class="text-center py-5"><strong>No categories yet</strong><p class="text-muted mb-3">Create the first category for your products.</p><a class="btn btn-ac" href="{{ route('admin.products.categories.create') }}">Add category</a></td></tr>@endforelse
    </tbody></table></div><div class="mt-3">{{ $categories->links() }}</div></div></div>
</div>
@endsection
