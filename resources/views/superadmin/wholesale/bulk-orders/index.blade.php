@extends('layouts.superadmin.app')
@section('title','Bulk Orders')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Wholesale', 'current' => 'Bulk Orders'])

            <div class="card"><div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <form method="GET" class="col-md-3 p-0">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                @foreach ($statuses as $st)
                                    <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </form>
                        <div class="ms-auto text-secondary">Total Revenue: <strong>{{ number_format($totalRevenue, 2) }}</strong></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Customer</th><th>Product</th><th>Quantity</th><th>Total Price</th><th>Status</th><th>Date</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $o)
                                <tr>
                                    <td>#{{ $o->id }}</td>
                                    <td>Customer #{{ $o->customer_id }}</td>
                                    <td>{{ $o->wholesaleProduct?->product?->name ?? '—' }}</td>
                                    <td>{{ $o->quantity }}</td>
                                    <td>{{ number_format($o->total_price, 2) }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $o->status])</td>
                                    <td>{{ $o->created_at?->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center py-4">No bulk orders found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
