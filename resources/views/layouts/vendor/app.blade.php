@extends('layouts.superadmin.app')

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@push('styles')
    <style>
        .vp-card{background:#fff;border-radius:.5rem;box-shadow:0 .1rem .7rem rgba(0,0,0,.08)}
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('vendor_content')
        </div>
    </div>
@endsection
