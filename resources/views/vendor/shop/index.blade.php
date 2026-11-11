@extends('layouts.superadmin.app')

@section('title', 'My Shop')

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Account</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Shop</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('vendor.shops.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Shop Information</h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="shop_name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_name" id="shop_name" class="form-control @error('shop_name') is-invalid @enderror"
                                           value="{{ old('shop_name', $vendor->shop_name) }}" required>
                                    @error('shop_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Shop URL</label>
                                    <input type="text" class="form-control" value="{{ $vendor->shop_slug }}" disabled>
                                    <small class="text-muted">URL slug admin chhara bodlano jay na.</small>
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="5" maxlength="2000"
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $vendor->description) }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Branding</h5>
                                <hr/>

                                <div class="row g-4">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold">Logo</label>
                                        @if ($vendor->logo)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $vendor->logo) }}" alt="logo" style="max-height:90px;border-radius:6px;" class="border p-1">
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="remove_logo" value="1" id="remove_logo">
                                                <label class="form-check-label text-danger small" for="remove_logo">Remove current logo</label>
                                            </div>
                                        @endif
                                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                        <small class="text-muted">Square image, max 2MB</small>
                                    </div>

                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold">Banner</label>
                                        @if ($vendor->banner)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $vendor->banner) }}" alt="banner" style="max-height:90px;max-width:100%;border-radius:6px;" class="border p-1">
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="remove_banner" value="1" id="remove_banner">
                                                <label class="form-check-label text-danger small" for="remove_banner">Remove current banner</label>
                                            </div>
                                        @endif
                                        <input type="file" name="banner" class="form-control @error('banner') is-invalid @enderror" accept="image/*">
                                        <small class="text-muted">Wide image (e.g. 1200x300), max 4MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 mb-4">
                            <i class="bx bx-save"></i> Save Shop
                        </button>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Account Status</h5>
                                <hr/>

                                @php
                                    $statusColor = in_array((string) $vendor->status, ['approved', '1'], true) ? 'success' : 'warning';
                                    $verifyColor = match ((string) $vendor->verification_status) {
                                        'verified', 'approved', '1' => 'success',
                                        'rejected'                  => 'danger',
                                        default                     => 'warning',
                                    };
                                @endphp

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Status</span>
                                    <span class="badge bg-light-{{ $statusColor }} text-{{ $statusColor }} text-uppercase">{{ $vendor->status }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Verification</span>
                                    <span class="badge bg-light-{{ $verifyColor }} text-{{ $verifyColor }} text-uppercase">{{ $vendor->verification_status ?: 'n/a' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Commission</span>
                                    <strong>{{ rtrim(rtrim(number_format((float) $vendor->commission_rate, 2), '0'), '.') }}%</strong>
                                </div>
                                <small class="text-muted">Ei tothyo gulo shudhu admin bodlate pare.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection