@extends('layouts.superadmin.app')
@section('title','Dropshipping Products')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping', 'current' => 'Products'])

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="active" @selected(request('status') === 'active')>Active</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th><th>Vendor</th><th>Supplier Product</th><th>Supplier</th>
                                <th>Base Price</th><th>Markup</th><th>Selling Price</th><th>Status</th><th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                @php $base = $item->supplierProduct?->base_price ?? 0; @endphp
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>{{ $item->vendor?->shop_name ?? $item->vendor?->name ?? '—' }}</td>
                                    <td>{{ $item->supplierProduct?->name ?? '—' }}</td>
                                    <td>{{ $item->supplierProduct?->supplier?->company_name ?? '—' }}</td>
                                    <td>{{ number_format($base, 2) }}</td>
                                    <td>{{ number_format($item->markup_price ?? 0, 2) }}</td>
                                    <td>{{ number_format($base + ($item->markup_price ?? 0), 2) }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $item->is_active])</td>
                                    <td>
                                        <form action="{{ route('superadmin.dropshipping.products.toggle', $item) }}" method="POST" class="m-0">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm {{ $item->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                                {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center py-4">No dropshipping products found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $items->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
