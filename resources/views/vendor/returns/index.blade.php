@extends('layouts.superadmin.app')

@section('title', 'Returns')

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
                <div class="breadcrumb-title pe-3">Sales</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Returns</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="text-muted small mb-3">Apnar product er return request. Approve/reject admin kore.</div>
                    @include('vendor.partials.generic-list', ['rows' => $rows, 'orders' => $orders, 'empty' => 'Kono return request nai.'])
                    <div class="mt-3">{{ $rows->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection