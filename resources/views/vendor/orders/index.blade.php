@extends('layouts.superadmin.app')

@section('title', 'My Orders')

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
                            <li class="breadcrumb-item active" aria-current="page">My Orders</li>
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

            {{-- Status tabs --}}
            <ul class="nav nav-pills mb-3 flex-wrap gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') ? '' : 'active' }}"
                       href="{{ route('vendor.orders.orders.index') }}">
                        All <span class="badge bg-secondary ms-1">{{ $statusCounts->sum() }}</span>
                    </a>
                </li>
                @foreach (config('order.statuses') as $key => $cfg)
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') === $key ? 'active' : '' }}"
                           href="{{ route('vendor.orders.orders.index', ['status' => $key]) }}">
                            {{ $cfg['label'] }} <span class="badge bg-secondary ms-1">{{ $statusCounts[$key] ?? 0 }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="card">
                <div class="card-body">

                    {{-- Filters --}}
                    <form method="GET" action="{{ route('vendor.orders.orders.index') }}" class="row g-2 mb-4">
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <div class="col-lg-3">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                   placeholder="Order no, name, phone">
                        </div>
                        <div class="col-lg-2">
                            <select name="payment_status" class="form-select">
                                <option value="">All payments</option>
                                @foreach (config('order.payment_statuses') as $key => $cfg)
                                    <option value="{{ $key }}" @selected(request('payment_status') === $key)>{{ $cfg['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
                            <a href="{{ route('vendor.orders.orders.index', request('status') ? ['status' => request('status')] : []) }}"
                               class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Order#</th>
                                <th>Customer</th>
                                <th>My Items</th>
                                <th>My Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td><h6 class="mb-0 font-14">#{{ $order->order_number ?? $order->id }}</h6></td>
                                    <td>
                                        {{ $order->name ?? '—' }}
                                        <div class="text-muted small">{{ $order->phone }}</div>
                                    </td>
                                    <td>{{ $order->vendor_items_count }}</td>
                                    <td>Tk. {{ number_format((float) $order->vendor_total, 2) }}</td>
                                    <td>@include('superadmin.orders._badge', ['type' => 'payment_statuses', 'value' => $order->payment_status])</td>
                                    <td>@include('superadmin.orders._badge', ['type' => 'statuses', 'value' => $order->status])</td>
                                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('vendor.orders.orders.show', $order->id) }}"
                                           class="btn btn-primary btn-sm radius-30 px-3">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No orders found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection