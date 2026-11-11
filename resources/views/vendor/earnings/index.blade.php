@extends('layouts.superadmin.app')

@section('title', 'Earnings')

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
                            <li class="breadcrumb-item active" aria-current="page">Earnings</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Total Sales</p>
                            <h4 class="my-1 text-info">৳{{ number_format($totalSales, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Marketplace Commission</p>
                            <h4 class="my-1 text-danger">৳{{ number_format($totalCommission, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <p class="mb-0 text-secondary">Net Earning</p>
                            <h4 class="my-1 text-success">৳{{ number_format($netEarning, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-muted small mb-3">Cancelled o returned order total e dhora hoyni.</div>

            <div class="card">
                <div class="card-body">

                    <form method="GET" action="{{ route('vendor.finance.earnings') }}" class="row g-2 mb-4">
                        <div class="col-lg-3">
                            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
                            <a href="{{ route('vendor.finance.earnings') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Order#</th>
                                <th>Date</th>
                                <th>Order Status</th>
                                <th class="text-end">Sales</th>
                                <th class="text-end">Commission</th>
                                <th class="text-end">Net</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($earnings as $row)
                                <tr>
                                    <td>#{{ $row->order->order_number ?? $row->order_id }}</td>
                                    <td>{{ $row->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if ($row->order)
                                            @include('superadmin.orders._badge', ['type' => 'statuses', 'value' => $row->order->status])
                                        @endif
                                    </td>
                                    <td class="text-end">৳{{ number_format($row->subtotal, 2) }}</td>
                                    <td class="text-end text-danger">- ৳{{ number_format($row->commission_amount, 2) }}</td>
                                    <td class="text-end text-success fw-semibold">৳{{ number_format($row->subtotal - $row->commission_amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('vendor.orders.orders.show', $row->order_id) }}" class="btn btn-primary btn-sm radius-30 px-3">Order</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center py-4">Kono earning nai.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $earnings->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection