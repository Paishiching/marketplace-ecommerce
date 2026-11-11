@extends('layouts.superadmin.app')

@section('title','Add Supplier')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Suppliers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.suppliers.index') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Supplier</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('superadmin.suppliers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
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
                                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Only users without an existing supplier account are shown</small>
                                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" id="company_name"
                                           class="form-control @error('company_name') is-invalid @enderror"
                                           placeholder="e.g. Dhaka Wholesale Ltd." value="{{ old('company_name') }}" required>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="company_slug" class="form-label">Company Slug</label>
                                    <input type="text" name="company_slug" id="company_slug"
                                           class="form-control @error('company_slug') is-invalid @enderror"
                                           placeholder="auto-generated-from-company-name" value="{{ old('company_slug') }}">
                                    <small class="text-muted">Leave blank to auto-generate</small>
                                    @error('company_slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="A short description of the company">{{ old('description') }}</textarea>
                                    @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-image text-primary"></i> Company Logo
                                </h5>
                                <hr/>
                                <div class="mb-0">
                                    <label for="logo" class="form-label">Logo <span class="text-danger">*</span></label>
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" required>
                                    <small class="text-muted">Recommended size: 400x400px, max 2MB</small>
                                    @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="logoPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-toggle-left text-primary"></i> Status
                                </h5>
                                <hr/>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" @selected(old('status', 'pending') == 'pending')>Pending</option>
                                    <option value="approved" @selected(old('status') == 'approved')>Approved</option>
                                    <option value="suspended" @selected(old('status') == 'suspended')>Suspended</option>
                                </select>
                                <small class="text-muted d-block mt-2">Approved দিলে supplier automatically Verified হবে।</small>
                                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.suppliers.index') }}" class="btn btn-outline-secondary btn-lg w-50">
                                <i class="bx bx-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">
                                <i class="bx bx-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#user_id').select2({ width: '100%' });
        });

        document.getElementById('company_name').addEventListener('input', function (e) {
            const slugField = document.getElementById('company_slug');
            if (!slugField.dataset.userEdited) {
                slugField.value = e.target.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
            }
        });
        document.getElementById('company_slug').addEventListener('input', function () {
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
