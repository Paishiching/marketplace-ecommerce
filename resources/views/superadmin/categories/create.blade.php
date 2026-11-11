@extends('layouts.superadmin.app')

@section('title','Add Category')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Catalog</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Category Information</h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Enter category name" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                           placeholder="auto-generated-from-name" value="{{ old('slug') }}">
                                    <small class="text-muted">Leave blank to auto-generate</small>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Category Image</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Organize</h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Parent Category</label>
                                    <select name="parent_id" id="parent_id" class="form-select">
                                        <option value="">None (This is a Main Category)</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Parent select korle eita SubCategory hishebe save hobe</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" checked>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.categories.index') }}" class="btn btn-outline-secondary btn-lg w-50">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">Save Category</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('name').addEventListener('input', function (e) {
            const slugField = document.getElementById('slug');
            if (!slugField.dataset.userEdited) {
                slugField.value = e.target.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
            }
        });
        document.getElementById('slug').addEventListener('input', function () {
            this.dataset.userEdited = 'true';
        });

        document.getElementById('image').addEventListener('change', function (e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            const file = e.target.files[0];
            if (file) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.maxHeight = '120px';
                img.style.borderRadius = '6px';
                preview.appendChild(img);
            }
        });
    </script>
@endpush
