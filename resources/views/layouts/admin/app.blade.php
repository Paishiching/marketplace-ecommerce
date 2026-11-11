@extends('layouts.superadmin.app')

@section('sidebar')
    @include('layouts.superadmin.sidebar')
@endsection

@section('header')
    @if (auth()->user()?->hasRole('superadmin'))
        @include('layouts.shared.panel-header', ['roleLabel' => 'Super Admin', 'dashboardRoute' => 'superadmin.dashboards'])
    @else
        @include('layouts.admin.header')
    @endif
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

            @yield('panel_content')
        </div>
    </div>
@endsection
