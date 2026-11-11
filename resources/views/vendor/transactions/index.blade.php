@extends('layouts.superadmin.app')

@section('title', 'Transactions')

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
                            <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($transactions as $t)
                                <tr>
                                    <td>{{ $t['date']->format('M d, Y h:i A') }}</td>
                                    <td>{{ $t['label'] }}</td>
                                    <td class="text-capitalize">{{ $t['status'] }}</td>
                                    <td class="text-end fw-semibold {{ $t['type'] === 'credit' ? 'text-success' : 'text-danger' }}">
                                        {{ $t['type'] === 'credit' ? '+' : '-' }} ৳{{ number_format($t['amount'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4">Kono transaction nai.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $transactions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection