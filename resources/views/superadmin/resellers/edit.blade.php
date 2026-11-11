@extends('layouts.superadmin.app')

@section('title','Edit Reseller')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Resellers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.resellers.index') }}">Resellers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Reseller</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.resellers.index') }}" class="btn btn-outline-secondary btn-sm">
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

            <form action="{{ route('superadmin.resellers.update', $reseller->id) }}" method="POST">
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
                                    <label for="user_id" class="form-label">User Account <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select User</option>
                                        @foreach($users ?? [] as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id', $reseller->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="business_name" class="form-label">Business Name <span class="text-danger">*</span></label>
                                    <input type="text" name="business_name" id="business_name"
                                           class="form-control @error('business_name') is-invalid @enderror"
                                           value="{{ old('business_name', $reseller->business_name) }}" required>
                                    @error('business_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-dollar-circle text-primary"></i> Markup
                                </h5>
                                <hr/>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" max="1000" name="markup_rate" id="markup_rate"
                                           class="form-control @error('markup_rate') is-invalid @enderror"
                                           value="{{ old('markup_rate', $reseller->markup_rate) }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('markup_rate') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
                                    @if ($reseller->status === 'approved')
                                        <span class="badge rounded-pill text-success bg-light-success px-3 py-2 text-uppercase">Approved</span>
                                    @elseif ($reseller->status === 'suspended')
                                        <span class="badge rounded-pill text-danger bg-light-danger px-3 py-2 text-uppercase">Suspended</span>
                                    @else
                                        <span class="badge rounded-pill text-warning bg-light-warning px-3 py-2 text-uppercase">Pending</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-0">Status বদলাতে <a href="{{ route('superadmin.resellers.show', $reseller->id) }}">Details page</a> থেকে Approve / Suspend করুন।</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.resellers.index') }}" class="btn btn-outline-secondary btn-lg w-50">
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
    </script>
@endpush
