@extends('layouts.superadmin.app')

@section('title','Add Vendor')

@section('content')

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Vendors</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.vendors.index') }}">Vendors</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Vendor</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.vendors.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back to Vendors
                    </a>
                </div>
            </div>
            <!--end breadcrumb-->

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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('superadmin.vendors.store') }}" method="POST" enctype="multipart/form-data" id="vendorForm">

                @csrf

                <div class="row">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-8">

                        <!-- Basic Info -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-info-circle text-primary"></i> Basic Information
                                </h5>
                                <p class="text-muted small mb-3">Link this vendor to a user account and set up the shop name.</p>
                                <hr/>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Owner (User Account) <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select User</option>
                                        @foreach($users ?? [] as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Only users without an existing vendor account are shown</small>
                                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shop_name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror"
                                           id="shop_name" placeholder="e.g. Rafiq's Fashion House" value="{{ old('shop_name') }}" required>
                                    @error('shop_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shop_slug" class="form-label">Shop Slug</label>
                                    <input type="text" name="shop_slug" class="form-control @error('shop_slug') is-invalid @enderror" id="shop_slug"
                                           placeholder="auto-generated-from-shop-name" value="{{ old('shop_slug') }}">
                                    <small class="text-muted">Leave blank to auto-generate from the shop name</small>
                                    @error('shop_slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Shop Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                              rows="4" placeholder="A short description of the shop shown on its storefront page">{{ old('description') }}</textarea>
                                    @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /Basic Info -->

                        <!-- Shop Images -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-image text-primary"></i> Shop Images
                                </h5>
                                <p class="text-muted small mb-3">Upload the shop logo and an optional banner shown on the storefront.</p>
                                <hr/>
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Shop Logo <span class="text-danger">*</span></label>
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" required>
                                    <small class="text-muted">Recommended size: 400x400px, max 2MB</small>
                                    @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="logoPreview" class="mt-2"></div>
                                </div>
                                <div class="mb-0">
                                    <label for="banner" class="form-label">Shop Banner</label>
                                    <input type="file" name="banner" id="banner" class="form-control @error('banner') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Recommended size: 1600x400px, max 2MB</small>
                                    @error('banner') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="bannerPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Shop Images -->

                    </div>
                    <!-- /LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-4">

                        <!-- Commission -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-dollar-circle text-primary"></i> Commission
                                </h5>
                                <hr/>
                                <div class="mb-0">
                                    <label for="commission_rate" class="form-label">Commission Rate</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" max="100" name="commission_rate" id="commission_rate"
                                               class="form-control @error('commission_rate') is-invalid @enderror" placeholder="e.g. 10" value="{{ old('commission_rate') }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <small class="text-muted">Platform's cut on this vendor's sales</small>
                                    @error('commission_rate') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /Commission -->

                        <!-- Verification -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-shield-quarter text-primary"></i> Verification
                                </h5>
                                <hr/>
                                <div class="mb-0">
                                    <label for="verification_status" class="form-label">Verification Status <span class="text-danger">*</span></label>
                                    <select name="verification_status" id="verification_status" class="form-select @error('verification_status') is-invalid @enderror" required>
                                        <option value="pending" @selected(old('verification_status', 'pending') == 'pending')>Pending</option>
                                        <option value="verified" @selected(old('verification_status') == 'verified')>Verified</option>
                                        <option value="rejected" @selected(old('verification_status') == 'rejected')>Rejected</option>
                                    </select>
                                    @error('verification_status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /Verification -->

                        <!-- Status -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-toggle-left text-primary"></i> Status
                                </h5>
                                <hr/>
                                <p class="text-muted small mb-0">
                                    Verification <strong>Verified</strong> দিলে vendor সরাসরি <strong>Approved</strong> হবে,
                                    নাহলে <strong>Pending</strong> থাকবে। পরে details page থেকে Approve / Suspend করা যাবে।
                                </p>
                            </div>
                        </div>
                        <!-- /Status -->

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.vendors.index') }}" class="btn btn-outline-secondary btn-lg w-50">
                                <i class="bx bx-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">
                                <i class="bx bx-save"></i> Save Vendor
                            </button>
                        </div>
                    </div>
                    <!-- /RIGHT COLUMN -->

                </div><!--end row-->
            </form>

        </div>
    </div>
    <!--end page wrapper -->

@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <style>
        .card-title i { font-size: 1.1rem; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#user_id, #verification_status').select2({ width: '100%' });
        });

        // Auto slug preview from shop name
        document.getElementById('shop_name').addEventListener('input', function (e) {
            const slugField = document.getElementById('shop_slug');
            if (!slugField.dataset.userEdited) {
                slugField.value = e.target.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
            }
        });
        document.getElementById('shop_slug').addEventListener('input', function () {
            this.dataset.userEdited = 'true';
        });

        function previewImage(inputId, previewId) {
            document.getElementById(inputId).addEventListener('change', function (e) {
                const preview = document.getElementById(previewId);
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
        }
        previewImage('logo', 'logoPreview');
        previewImage('banner', 'bannerPreview');
    </script>
@endpush
