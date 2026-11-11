@extends('layouts.admin.app')
@section('title', 'Add product')
@section('panel_content')
<style>
    .admin-product-form{--ap-navy:#2a3582;--ap-orange:#fd6801}.admin-product-form .form-card{border:1px solid #e9ebf2;border-radius:15px;box-shadow:0 8px 28px rgba(35,47,103,.06)}.admin-product-form h3,.admin-product-form h5{color:var(--ap-navy);font-weight:750}.admin-product-form .form-label{font-size:13px;font-weight:650;color:#38416f}.admin-product-form .form-control,.admin-product-form .form-select{min-height:45px;border-radius:9px;border-color:#dfe3f0}.admin-product-form textarea.form-control{min-height:110px}.admin-product-form .btn-ac{background:var(--ap-orange);border-color:var(--ap-orange);color:#fff;font-weight:650;border-radius:9px}.admin-product-form .hint{font-size:12px;color:#6c7288}
</style>
<div class="admin-product-form">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h3 class="mb-1">Add product</h3><p class="text-muted mb-0">Enter the key details. New products are sent for review before publishing.</p></div><a href="{{ route('admin.products.products.index') }}" class="btn btn-outline-secondary">Back to products</a></div>
    @if($errors->any())<div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if(!$categories->count())<div class="alert alert-warning">Create an active category first, then add a product.</div>@endif
    <form method="POST" action="{{ route('admin.products.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card form-card mb-3"><div class="card-body p-3 p-lg-4"><h5 class="mb-3">Product information</h5>
            <div class="row g-3"><div class="col-md-8"><label class="form-label" for="name">Product name <span class="text-danger">*</span></label><input class="form-control" id="name" name="name" value="{{ old('name') }}" maxlength="191" required placeholder="e.g. Samsung Galaxy A55"></div>
                <div class="col-md-4"><label class="form-label" for="sku">SKU <span class="text-muted fw-normal">(optional)</span></label><input class="form-control" id="sku" name="sku" value="{{ old('sku') }}" maxlength="100" placeholder="Product code"></div>
                <div class="col-md-6"><label class="form-label" for="category">Category <span class="text-danger">*</span></label><select class="form-select" id="category" name="category_id" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label" for="subCategory">Subcategory</label><select class="form-select" id="subCategory" name="sub_category_id"><option value="">Select subcategory (optional)</option>@foreach($subCategories as $subCategory)<option value="{{ $subCategory->id }}" data-parent="{{ $subCategory->parent_id }}" @selected(old('sub_category_id') == $subCategory->id)>{{ $subCategory->name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label" for="brand">Brand</label><select class="form-select" id="brand" name="brand_id"><option value="">No brand</option>@foreach($brands as $brand)<option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label" for="slug">URL slug <span class="text-muted fw-normal">(automatic if blank)</span></label><input class="form-control" id="slug" name="slug" value="{{ old('slug') }}" maxlength="191" placeholder="product-name"></div>
                <div class="col-12"><label class="form-label" for="shortDescription">Short description</label><input class="form-control" id="shortDescription" name="short_description" value="{{ old('short_description') }}" maxlength="500" placeholder="A short summary customers can scan quickly"></div>
                <div class="col-12"><label class="form-label" for="description">Product details</label><textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe features, specifications and what is included">{{ old('description') }}</textarea></div>
                <div class="col-md-6"><label class="form-label" for="thumbnail">Product image</label><input class="form-control" id="thumbnail" type="file" name="thumbnail" accept="image/*"><div class="hint mt-1">Optional · JPG, PNG or WebP · up to 2 MB</div></div>
                <div class="col-md-6"><label class="form-label" for="tags">Search tags <span class="text-muted fw-normal">(optional)</span></label><input class="form-control" id="tags" name="tags" value="{{ old('tags') }}" maxlength="255" placeholder="mobile, samsung, smartphone"></div>
            </div>
        </div></div>
        <div class="card form-card mb-3"><div class="card-body p-3 p-lg-4"><h5 class="mb-3">Price</h5><div class="row g-3"><div class="col-md-6"><label class="form-label" for="price">Regular price (৳) <span class="text-danger">*</span></label><input class="form-control" id="price" type="number" name="price" min="0" step="0.01" value="{{ old('price') }}" required></div><div class="col-md-6"><label class="form-label" for="discountPrice">Discount price (৳) <span class="text-muted fw-normal">(optional)</span></label><input class="form-control" id="discountPrice" type="number" name="discount_price" min="0" step="0.01" value="{{ old('discount_price') }}"><div class="hint mt-1">Leave blank if there is no discount. Must be below the regular price.</div></div></div></div></div>
        <div class="d-flex flex-wrap justify-content-end gap-2"><a class="btn btn-outline-secondary px-4" href="{{ route('admin.products.products.index') }}">Cancel</a><button class="btn btn-ac px-4" type="submit" @disabled(!$categories->count())>Create product</button></div>
    </form>
</div>
<script>
(()=>{const category=document.getElementById('category'),sub=document.getElementById('subCategory');const filter=()=>{Array.from(sub.options).forEach(option=>{if(!option.value)return;option.hidden=option.dataset.parent!==category.value;if(option.hidden&&option.selected)sub.value='';});};category.addEventListener('change',filter);filter();})();
</script>
@endsection
