@extends('layouts.superadmin.app')

@section('title','Add Brand')

@section('content')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.brands.index') }}">Brands</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Brand</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.brands.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back to Brands
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong><i class="bx bx-error-circle"></i> Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('superadmin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-tag text-primary"></i> Brand Information
                                </h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                           placeholder="e.g. Nestle, Samsung" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                                           placeholder="auto-generated-from-name" value="{{ old('slug') }}">
                                    <small class="text-muted">Leave blank to auto-generate</small>
                                    @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control" placeholder="Short description about the brand">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-image text-primary"></i> Brand Logo
                                </h5>
                                <hr/>
                                <div class="mb-0">
                                    <label for="logo" class="form-label">Logo Image</label>
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Recommended: 300x300px, max 1MB</small>
                                    @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="logoPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-toggle-left text-primary"></i> Status
                                </h5>
                                <hr/>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" checked>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.brands.index') }}" class="btn btn-outline-secondary btn-lg w-50">
                                <i class="bx bx-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">
                                <i class="bx bx-save"></i> Save Brand
                            </button>
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

        document.getElementById('logo').addEventListener('change', function (e) {
            const preview = document.getElementById('logoPreview');
            preview.innerHTML = '';
            const file = e.target.files[0];
            if (file) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.maxHeight = '100px';
                img.style.borderRadius = '6px';
                preview.appendChild(img);
            }
        });
    </script>
@endpush
