@extends('layouts.superadmin.app')

@section('title','Edit Supplier')

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
                            <li class="breadcrumb-item active" aria-current="page">Edit Supplier</li>
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

            <form action="{{ route('superadmin.suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                            <option value="{{ $user->id }}" @selected(old('user_id', $supplier->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" id="company_name"
                                           class="form-control @error('company_name') is-invalid @enderror"
                                           value="{{ old('company_name', $supplier->company_name) }}" required>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="company_slug" class="form-label">Company Slug</label>
                                    <input type="text" name="company_slug" id="company_slug"
                                           class="form-control @error('company_slug') is-invalid @enderror"
                                           value="{{ old('company_slug', $supplier->company_slug) }}">
                                    @error('company_slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4"
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $supplier->description) }}</textarea>
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
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">নতুন ছবি না দিলে আগেরটাই থাকবে (max 2MB)</small>
                                    @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="logoPreview" class="mt-2">
                                        @if ($supplier->logo)
                                            <img src="{{ asset('storage/' . $supplier->logo) }}" style="max-height:100px;border-radius:6px;">
                                        @endif
                                    </div>
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Current</span>
                                    @if ($supplier->status === 'approved')
                                        <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Approved</span>
                                    @elseif ($supplier->status === 'suspended')
                                        <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Suspended</span>
                                    @else
                                        <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-0">Status বদলাতে <a href="{{ route('superadmin.suppliers.show', $supplier->id) }}">Details page</a> থেকে Approve / Suspend করুন।</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.suppliers.index') }}" class="btn btn-outline-secondary btn-lg w-50">
                                <i class="bx bx-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">
                                <i class="bx bx-save"></i> Update
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
