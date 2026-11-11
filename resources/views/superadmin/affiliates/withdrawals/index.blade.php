@extends('layouts.superadmin.app')
@section('title','Withdrawals')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Finance', 'current' => 'Withdrawals'])

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
                                @foreach ($types as $t)
                                    <option value="{{ $t }}" @selected(request('type') === $t)>{{ ucfirst($t) }}</option>
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
                            <tr><th>ID#</th><th>Type</th><th>Requested By</th><th>Amount</th><th>Method</th><th>Account</th><th>Status</th><th>Date</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($withdrawals as $w)
                                <tr>
                                    <td>#{{ $w->id }}</td>
                                    <td>{{ class_basename($w->withdrawable_type) }}</td>
                                    <td>{{ $w->holder_name }}</td>
                                    <td>{{ number_format($w->amount, 2) }}</td>
                                    <td>{{ $w->method ?? '—' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($w->account_details ?? '—', 30) }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $w->status])</td>
                                    <td>{{ $w->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if ($w->status === 'pending')
                                                <form action="{{ route('superadmin.withdrawals.status', $w) }}" method="POST" class="m-0">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button class="btn btn-sm btn-outline-success">Approve</button>
                                                </form>
                                                <form action="{{ route('superadmin.withdrawals.status', $w) }}" method="POST" class="m-0"
                                                      onsubmit="return confirm('Reject this withdrawal?');">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button class="btn btn-sm btn-outline-danger">Reject</button>
                                                </form>
                                            @elseif ($w->status === 'approved')
                                                <form action="{{ route('superadmin.withdrawals.status', $w) }}" method="POST" class="m-0">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="paid">
                                                    <button class="btn btn-sm btn-success">Mark Paid</button>
                                                </form>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center py-4">No withdrawals found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $withdrawals->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
