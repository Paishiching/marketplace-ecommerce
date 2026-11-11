@extends('layouts.admin.app')
@section('title', 'Add category')
@section('panel_content')
<style>
    .admin-category-form{--ac-navy:#2a3582;--ac-orange:#fd6801}.admin-category-form .form-card{border:1px solid #e9ebf2;border-radius:15px;box-shadow:0 8px 28px rgba(35,47,103,.06)}.admin-category-form h3,.admin-category-form h5{color:var(--ac-navy);font-weight:750}.admin-category-form .form-label{font-size:13px;font-weight:650;color:#38416f}.admin-category-form .form-control,.admin-category-form .form-select{min-height:45px;border-radius:9px;border-color:#dfe3f0}.admin-category-form .btn-ac{background:var(--ac-orange);border-color:var(--ac-orange);color:#fff;font-weight:650;border-radius:9px}
</style>
<div class="admin-category-form"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h3 class="mb-1">Add category</h3><p class="text-muted mb-0">Create a main category or place it under an existing parent.</p></div><a href="{{ route('admin.products.categories.index') }}" class="btn btn-outline-secondary">Back to categories</a></div>
    @if($errors->any())<div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.products.categories.store') }}" enctype="multipart/form-data">@csrf
        <div class="card form-card mb-3"><div class="card-body p-3 p-lg-4"><h5 class="mb-3">Category details</h5><div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="name">Category name <span class="text-danger">*</span></label><input class="form-control" id="name" name="name" value="{{ old('name') }}" maxlength="191" placeholder="e.g. Home Appliances" required></div>
            <div class="col-md-6"><label class="form-label" for="parent">Parent category</label><select class="form-select" id="parent" name="parent_id"><option value="">Main category</option>@foreach($parentCategories as $parent)<option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>{{ $parent->name }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label" for="slug">URL slug <span class="text-muted fw-normal">(automatic if blank)</span></label><input class="form-control" id="slug" name="slug" value="{{ old('slug') }}" maxlength="191" placeholder="home-appliances"></div>
            <div class="col-md-6"><label class="form-label" for="image">Category image <span class="text-muted fw-normal">(optional)</span></label><input class="form-control" id="image" name="image" type="file" accept="image/*"></div>
            <div class="col-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" @checked(old('status', '1'))><label class="form-check-label" for="status">Active and available for product selection</label></div></div>
        </div></div></div>
        <div class="d-flex justify-content-end gap-2"><a class="btn btn-outline-secondary px-4" href="{{ route('admin.products.categories.index') }}">Cancel</a><button class="btn btn-ac px-4" type="submit">Create category</button></div>
    </form>
</div>
@endsection
