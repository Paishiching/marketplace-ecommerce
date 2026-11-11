@extends('layouts.affiliate.app')

@section('title', 'Sales')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Performance</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('affiliate.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sales</li>
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- Summary --}}
            <div class="row row-cols-1 row-cols-md-3">
                @foreach (['pending' => 'warning', 'approved' => 'info', 'paid' => 'success'] as $st => $color)
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-3 border-{{ $color }}">
                            <div class="card-body">
                                <p class="mb-0 text-secondary text-capitalize">{{ $st }} Commission</p>
                                <h4 class="my-1 text-{{ $color }}">৳{{ number_format($summary[$st]->commission ?? 0, 2) }}</h4>
                                <small class="text-muted">{{ $summary[$st]->total ?? 0 }} sale(s)</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h6 class="mb-0 text-uppercase">Sales History</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <form method="GET" class="ms-auto d-flex gap-2">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                @foreach (['pending', 'approved', 'paid', 'rejected'] as $st)
                                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Order</th>
                                <th>Product</th>
                                <th>Sale Amount</th>
                                <th>Commission</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($sales as $sale)
                                @php
                                    $color = match($sale->status) {
                                        'paid'     => 'success',
                                        'approved' => 'info',
                                        'pending'  => 'warning',
                                        default    => 'danger',
                                    };
                                @endphp
                                <tr>
                                    <td>#{{ $sale->id }}</td>
                                    <td>{{ $sale->order->order_number ?? '#' . $sale->order_id }}</td>
                                    <td>{{ $sale->link->product->name ?? '—' }}</td>
                                    <td>৳{{ number_format($sale->sale_amount, 2) }}</td>
                                    <td>৳{{ number_format($sale->commission_amount, 2) }}</td>
                                    <td>
                                        <div class="badge rounded-pill text-{{ $color }} bg-light-{{ $color }} p-2 text-uppercase px-3">
                                            <i class='bx bxs-circle me-1'></i>{{ ucfirst($sale->status) }}
                                        </div>
                                    </td>
                                    <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No sales found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $sales->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
