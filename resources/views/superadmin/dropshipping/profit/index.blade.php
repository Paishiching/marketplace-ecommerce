@extends('layouts.superadmin.app')
@section('title','Dropshipping Profit Report')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping', 'current' => 'Profit Report'])

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                @foreach ([
                    ['Orders', number_format($totals['orders']), 'info'],
                    ['Units Sold', number_format($totals['units']), 'warning'],
                    ['Supplier Cost', number_format($totals['cost'], 2), 'danger'],
                    ['Vendor Profit', number_format($totals['profit'], 2), 'success'],
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
                        <div class="col-md-2">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('superadmin.dropshipping.profit.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>Vendor</th><th>Orders</th><th>Units</th><th>Supplier Cost</th><th>Profit</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($rows as $r)
                                <tr>
                                    <td>{{ $r->vendor_name ?? 'Vendor #' . $r->vendor_id }}</td>
                                    <td>{{ $r->orders }}</td>
                                    <td>{{ $r->units }}</td>
                                    <td>{{ number_format($r->cost, 2) }}</td>
                                    <td class="text-success fw-bold">{{ number_format($r->profit, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No data for this period.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div></div>
        </div></div>
@endsection
