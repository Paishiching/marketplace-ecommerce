@extends('layouts.superadmin.app')

@section('title', 'Balance')

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
                <div class="breadcrumb-title pe-3">Finance</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Balance</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('vendor.finance.withdrawals.index') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-money"></i> Withdraw
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Available Balance</p>
                            <h4 class="my-1 text-success">৳{{ number_format($wallet['available'], 2) }}</h4>
                            <small class="text-muted">Minimum withdraw ৳{{ number_format($minimum) }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Pending Withdrawal</p>
                            <h4 class="my-1 text-warning">৳{{ number_format($wallet['pending'], 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Total Withdrawn</p>
                            <h4 class="my-1 text-info">৳{{ number_format($wallet['paid'], 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card radius-10 border-start border-0 border-3 border-primary">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Total Earned</p>
                            <h4 class="my-1 text-primary">৳{{ number_format($wallet['earned'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-muted small">
                Shudhu <b>Delivered / Completed</b> order-er taka (commission bad diye) earning-e dhora hoy. Pending order-er taka delivery-r por available hobe.
            </div>
        </div>
    </div>
@endsection