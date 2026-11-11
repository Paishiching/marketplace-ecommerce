@extends('layouts.superadmin.app')
@section('title','Import / Sync')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping', 'current' => 'Import / Sync'])

            <h6 class="mb-0 text-uppercase">Product Imports</h6><hr/>
            <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Vendor</th><th>Supplier Product</th><th>Status</th><th>Date</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($imports as $i)
                                <tr>
                                    <td>#{{ $i->id }}</td>
                                    <td>{{ $i->vendor?->shop_name ?? $i->vendor?->name ?? '—' }}</td>
                                    <td>{{ $i->supplierProduct?->name ?? '—' }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $i->status])</td>
                                    <td>{{ $i->created_at?->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No imports found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $imports->links('pagination::bootstrap-5') }}</div>
                </div></div>

            <h6 class="mb-0 text-uppercase">Product Syncs</h6><hr/>
            <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Vendor</th><th>Product</th><th>Last Synced</th><th>Sync Status</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($syncs as $s)
                                <tr>
                                    <td>#{{ $s->id }}</td>
                                    <td>{{ $s->dropshippingProduct?->vendor?->shop_name ?? $s->dropshippingProduct?->vendor?->name ?? '—' }}</td>
                                    <td>{{ $s->dropshippingProduct?->supplierProduct?->name ?? '—' }}</td>
                                    <td>{{ $s->last_synced_at?->format('M d, Y h:i A') ?? 'Never' }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $s->sync_status])</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No syncs found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $syncs->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
