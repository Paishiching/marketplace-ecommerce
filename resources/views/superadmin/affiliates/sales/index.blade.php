@extends('layouts.superadmin.app')
@section('title','Affiliate Sales')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Affiliates', 'current' => 'Sales'])

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
                            <select name="affiliate_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Affiliates</option>
                                @foreach ($affiliates as $a)
                                    <option value="{{ $a->id }}" @selected(request('affiliate_id') == $a->id)>{{ $a->user?->name ?? $a->referral_code }}</option>
                                @endforeach
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
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Affiliate</th><th>Order</th><th>Sale Amount</th><th>Commission</th><th>Status</th><th>Date</th><th style="width:170px">Update</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($sales as $s)
                                <tr>
                                    <td>#{{ $s->id }}</td>
                                    <td>{{ $s->affiliate?->user?->name ?? $s->affiliate?->referral_code ?? '—' }}</td>
                                    <td>{{ $s->order_id ? '#' . $s->order_id : '—' }}</td>
                                    <td>{{ number_format($s->sale_amount, 2) }}</td>
                                    <td>{{ number_format($s->commission_amount, 2) }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $s->status])</td>
                                    <td>{{ $s->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.affiliate.sales.status', $s) }}" method="POST" class="d-flex gap-1 m-0">
                                            @csrf @method('PATCH')
                                            <select name="status" class="form-select form-select-sm">
                                                @foreach ($statuses as $st)
                                                    <option value="{{ $st }}" @selected($s->status === $st)>{{ ucfirst($st) }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-primary">Go</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4">No affiliate sales found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $sales->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
