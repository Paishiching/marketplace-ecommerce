@extends('layouts.superadmin.app')

@section('sidebar')
    @include('layouts.reseller.sidebar')
@endsection

@section('header')
    @include('layouts.reseller.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('reseller_content')
        </div>
    </div>
@endsection
