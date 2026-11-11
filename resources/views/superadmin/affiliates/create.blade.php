@extends('layouts.superadmin.app')

@section('title','Add Affiliate')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Affiliates</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.affiliates.index') }}">Affiliates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Affiliate</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.affiliates.index') }}" class="btn btn-outline-secondary btn-sm">
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

            <form action="{{ route('superadmin.affiliates.store') }}" method="POST">
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
                                    <label for="user_id" class="form-label">User Account <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select User</option>
                                        @foreach($users ?? [] as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Only users without an existing affiliate account are shown</small>
                                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="referral_code" class="form-label">Referral Code</label>
                                    <input type="text" name="referral_code" id="referral_code" maxlength="50"
                                           class="form-control @error('referral_code') is-invalid @enderror"
                                           placeholder="Leave blank to auto-generate" value="{{ old('referral_code') }}">
                                    @error('referral_code') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

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
                                           placeholder="e.g. 5" value="{{ old('commission_rate') }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                <small class="text-muted">Per sale commission for this affiliate</small>
                                @error('commission_rate') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

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
                                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.affiliates.index') }}" class="btn btn-outline-secondary btn-lg w-50">
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
    </script>
@endpush
