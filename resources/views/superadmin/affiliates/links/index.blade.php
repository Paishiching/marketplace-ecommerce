@extends('layouts.superadmin.app')
@section('title','Affiliate Links')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Affiliates', 'current' => 'Links'])

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3">
                            <select name="affiliate_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Affiliates</option>
                                @foreach ($affiliates as $a)
                                    <option value="{{ $a->id }}" @selected(request('affiliate_id') == $a->id)>{{ $a->user?->name ?? $a->referral_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Affiliate</th><th>Product</th><th>Code</th><th>Clicks</th><th>Sales</th><th>Status</th><th>Date</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($links as $l)
                                <tr>
                                    <td>#{{ $l->id }}</td>
                                    <td>{{ $l->affiliate?->user?->name ?? $l->affiliate?->referral_code ?? '—' }}</td>
                                    <td>{{ $l->product?->name ?? 'General link' }}</td>
                                    <td><code>{{ $l->code }}</code></td>
                                    <td>{{ $l->clicks_count }}</td>
                                    <td>{{ $l->sales_count }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $l->is_active])</td>
                                    <td>{{ $l->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.affiliate.links.toggle', $l) }}" method="POST" class="m-0">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm {{ $l->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                                {{ $l->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center py-4">No affiliate links found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $links->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
