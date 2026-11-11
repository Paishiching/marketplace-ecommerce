@extends('layouts.superadmin.app')
@section('title','Dropshipping Suppliers')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping', 'current' => 'Suppliers'])

            <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th><th>Company</th><th>Verified</th><th>Status</th>
                                <th>Products</th><th>Orders</th><th>Total Cost</th><th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($suppliers as $s)
                                <tr>
                                    <td>#{{ $s->id }}</td>
                                    <td>{{ $s->company_name }}</td>
                                    <td>{!! $s->is_verified ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $s->status])</td>
                                    <td>{{ $s->supplier_products_count }}</td>
                                    <td>{{ $s->dropshipping_orders_count }}</td>
                                    <td>{{ number_format($s->dropshipping_orders_sum_total_cost ?? 0, 2) }}</td>
                                    <td><a href="{{ route('superadmin.suppliers.show', $s->id) }}" class="btn btn-primary radius-30" style="font-size:12px;padding:4px 12px;">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No suppliers found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $suppliers->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
