@extends('layouts.superadmin.app')
@section('title','Dropshipping Orders')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping', 'current' => 'Orders'])

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                @foreach ($statuses as $st)
                                    <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th><th>Vendor</th><th>Supplier</th><th>Items</th>
                                <th>Total Cost</th><th>Status</th><th>Date</th><th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $o)
                                <tr>
                                    <td>#{{ $o->id }}</td>
                                    <td>{{ $o->vendor?->shop_name ?? $o->vendor?->name ?? '—' }}</td>
                                    <td>{{ $o->supplier?->company_name ?? '—' }}</td>
                                    <td>{{ $o->items_count }}</td>
                                    <td>{{ number_format($o->total_cost, 2) }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $o->status])</td>
                                    <td>{{ $o->created_at?->format('M d, Y') }}</td>
                                    <td><a href="{{ route('superadmin.dropshipping.orders.show', $o) }}" class="btn btn-primary radius-30" style="font-size:12px;padding:4px 12px;">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No orders found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
