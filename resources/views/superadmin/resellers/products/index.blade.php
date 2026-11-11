@extends('layouts.superadmin.app')
@section('title','Reseller Products')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Resellers', 'current' => 'Products'])

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3">
                            <select name="reseller_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Resellers</option>
                                @foreach ($resellers as $r)
                                    <option value="{{ $r->id }}" @selected(request('reseller_id') == $r->id)>{{ $r->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="active" @selected(request('status') === 'active')>Active</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th><th>Reseller</th><th>Product</th><th>Base Price</th>
                                <th>Selling Price</th><th>Status</th><th>Date</th><th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>{{ $item->reseller?->business_name ?? '—' }}</td>
                                    <td>{{ $item->product?->name ?? '—' }}</td>
                                    <td>{{ $item->product?->price !== null ? number_format($item->product->price, 2) : '—' }}</td>
                                    <td>{{ $item->price ? number_format($item->price->selling_price, 2) : 'Not set' }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $item->is_active])</td>
                                    <td>{{ $item->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.reseller.products.toggle', $item) }}" method="POST" class="m-0">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm {{ $item->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                                {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No reseller products found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $items->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
