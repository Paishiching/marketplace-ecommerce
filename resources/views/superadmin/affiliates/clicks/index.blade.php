@extends('layouts.superadmin.app')
@section('title','Affiliate Clicks')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Affiliates', 'current' => 'Clicks'])

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-info"><div class="card-body">
                            <p class="mb-0 text-secondary">Total Clicks</p>
                            <h4 class="my-1 text-info">{{ number_format($stats['total']) }}</h4>
                        </div></div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success"><div class="card-body">
                            <p class="mb-0 text-secondary">Today</p>
                            <h4 class="my-1 text-success">{{ number_format($stats['today']) }}</h4>
                        </div></div>
                </div>
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
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Affiliate</th><th>Link Code</th><th>IP</th><th>Referrer</th><th>Date</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($clicks as $c)
                                <tr>
                                    <td>#{{ $c->id }}</td>
                                    <td>{{ $c->link?->affiliate?->user?->name ?? $c->link?->affiliate?->referral_code ?? '—' }}</td>
                                    <td><code>{{ $c->link?->code ?? '—' }}</code></td>
                                    <td>{{ $c->ip_address ?? '—' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($c->referrer ?? '—', 40) }}</td>
                                    <td>{{ $c->created_at?->format('M d, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4">No clicks found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $clicks->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
