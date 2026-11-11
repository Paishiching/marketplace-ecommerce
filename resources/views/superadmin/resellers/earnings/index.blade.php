@extends('layouts.superadmin.app')
@section('title','Reseller Earnings')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Resellers', 'current' => 'Earnings'])

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                @foreach ([
                    ['Orders', number_format($totals['orders']), 'info'],
                    ['Revenue', number_format($totals['revenue'], 2), 'warning'],
                    ['Product Cost', number_format($totals['cost'], 2), 'danger'],
                    ['Reseller Earning', number_format($totals['earning'], 2), 'success'],
                ] as [$label, $value, $color])
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-3 border-{{ $color }}">
                            <div class="card-body">
                                <p class="mb-0 text-secondary">{{ $label }}</p>
                                <h4 class="my-1 text-{{ $color }}">{{ $value }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
                        <div class="col-md-3"><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
                        <div class="col-md-3">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('superadmin.reseller.earnings.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>Reseller</th><th>Orders</th><th>Units</th><th>Revenue</th><th>Product Cost</th><th>Earning</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($rows as $r)
                                <tr>
                                    <td>{{ $r->business_name }}</td>
                                    <td>{{ $r->orders }}</td>
                                    <td>{{ $r->units }}</td>
                                    <td>{{ number_format($r->revenue, 2) }}</td>
                                    <td>{{ number_format($r->cost, 2) }}</td>
                                    <td class="fw-bold {{ $r->earning < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($r->earning, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4">No data for this period.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div></div>
        </div></div>
@endsection
