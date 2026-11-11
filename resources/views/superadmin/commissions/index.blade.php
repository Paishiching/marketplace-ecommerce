@extends('layouts.superadmin.app')
@section('title','Commissions')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Finance', 'current' => 'Commissions'])

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                @foreach ([['pending','warning'],['approved','info'],['paid','success'],['rejected','danger']] as [$st, $color])
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-3 border-{{ $color }}">
                            <div class="card-body">
                                <p class="mb-0 text-secondary text-capitalize">{{ $st }} ({{ $summary[$st]->total ?? 0 }})</p>
                                <h4 class="my-1 text-{{ $color }}">{{ number_format($summary[$st]->sum ?? 0, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3">
                            <select name="type" class="form-select" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="vendor" @selected(request('type') === 'vendor')>Vendor</option>
                                <option value="affiliate" @selected(request('type') === 'affiliate')>Affiliate</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                @foreach ($statuses as $st)
                                    <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 ms-auto text-end">
                            <a href="{{ route('superadmin.commission-rules.index') }}" class="btn btn-outline-primary">Manage Rules</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Order Item</th><th>Vendor</th><th>Affiliate</th><th>Amount</th><th>Status</th><th>Date</th><th>Details</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($commissions as $c)
                                <tr>
                                    <td>#{{ $c->id }}</td>
                                    <td>{{ $c->order_item_id ? '#' . $c->order_item_id : '—' }}</td>
                                    <td>{{ $c->vendor?->shop_name ?? $c->vendor?->name ?? '—' }}</td>
                                    <td>{{ $c->affiliate_id ? 'Affiliate #' . $c->affiliate_id : '—' }}</td>
                                    <td>{{ number_format($c->amount, 2) }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $c->status])</td>
                                    <td>{{ $c->created_at?->format('M d, Y') }}</td>
                                    <td><a href="{{ route('superadmin.commissions.show', $c) }}" class="btn btn-primary radius-30" style="font-size:12px;padding:4px 12px;">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No commissions found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $commissions->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
