@extends('layouts.superadmin.app')

@section('title','Edit Vendor')

@section('content')

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
                            <li class="breadcrumb-item active" aria-current="page">Edit Vendor</li>
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('superadmin.vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data" id="vendorForm">
                @csrf
                @method('PUT')

                <div class="row">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-8">

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-info-circle text-primary"></i> Basic Information
                                </h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Owner (User Account) <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select User</option>
                                        @foreach($users ?? [] as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id', $vendor->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shop_name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_name" id="shop_name" class="form-control @error('shop_name') is-invalid @enderror"
                                           value="{{ old('shop_name', $vendor->shop_name) }}" required>
                                    @error('shop_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shop_slug" class="form-label">Shop Slug</label>
                                    <input type="text" name="shop_slug" id="shop_slug" class="form-control @error('shop_slug') is-invalid @enderror"
                                           value="{{ old('shop_slug', $vendor->shop_slug) }}">
                                    @error('shop_slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Shop Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $vendor->description) }}</textarea>
                                    @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-image text-primary"></i> Shop Images
                                </h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="logo" class="form-label">Shop Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">নতুন ছবি না দিলে আগেরটাই থাকবে (max 2MB)</small>
                                    @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="logoPreview" class="mt-2">
                                        @if ($vendor->logo)
                                            <img src="{{ asset('storage/' . $vendor->logo) }}" style="max-height:100px;border-radius:6px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label for="banner" class="form-label">Shop Banner</label>
                                    <input type="file" name="banner" id="banner" class="form-control @error('banner') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">নতুন ছবি না দিলে আগেরটাই থাকবে (max 2MB)</small>
                                    @error('banner') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="bannerPreview" class="mt-2">
                                        @if ($vendor->banner)
                                            <img src="{{ asset('storage/' . $vendor->banner) }}" style="max-height:100px;border-radius:6px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-4">

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-dollar-circle text-primary"></i> Commission
                                </h5>
                                <hr/>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" max="100" name="commission_rate" id="commission_rate"
                                           class="form-control @error('commission_rate') is-invalid @enderror"
                                           value="{{ old('commission_rate', $vendor->commission_rate) }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('commission_rate') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-shield-quarter text-primary"></i> Verification
                                </h5>
                                <hr/>
                                <select name="verification_status" id="verification_status" class="form-select @error('verification_status') is-invalid @enderror" required>
                                    @foreach (['pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('verification_status', $vendor->verification_status) == $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('verification_status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-toggle-left text-primary"></i> Status
                                </h5>
                                <hr/>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Current</span>
                                    @if ($vendor->status === 'approved')
                                        <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Approved</span>
                                    @elseif ($vendor->status === 'suspended')
                                        <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Suspended</span>
                                    @else
                                        <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-0">Status বদলাতে <a href="{{ route('superadmin.vendors.show', $vendor->id) }}">Details page</a> থেকে Approve / Suspend করুন।</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.vendors.index') }}" class="btn btn-outline-secondary btn-lg w-50">
                                <i class="bx bx-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">
                                <i class="bx bx-save"></i> Update
                            </button>
                        </div>
                    </div>
                    <!-- /RIGHT COLUMN -->

                </div>
            </form>

        </div>
    </div>

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
