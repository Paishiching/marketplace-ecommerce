@extends('layouts.superadmin.app')
@section('title','Commission #' . $commission->id)
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Commissions', 'current' => 'Commission #' . $commission->id])

            <div class="row">
                <div class="col-lg-7">
                    <div class="card"><div class="card-body">
                            <h5 class="card-title">Details</h5><hr/>
                            <table class="table table-sm mb-0">
                                <tr><th style="width:35%">Order Item</th><td>{{ $commission->order_item_id ? '#' . $commission->order_item_id : '—' }}</td></tr>
                                <tr><th>Vendor</th><td>{{ $commission->vendor?->shop_name ?? $commission->vendor?->name ?? '—' }}</td></tr>
                                <tr><th>Affiliate</th><td>{{ $commission->affiliate_id ? 'Affiliate #' . $commission->affiliate_id : '—' }}</td></tr>
                                <tr><th>Amount</th><td>{{ number_format($commission->amount, 2) }}</td></tr>
                                <tr><th>Status</th><td>@include('superadmin.partials.status-badge', ['status' => $commission->status])</td></tr>
                                <tr><th>Created</th><td>{{ $commission->created_at?->format('M d, Y h:i A') }}</td></tr>
                            </table>
                        </div></div>
                </div>
                <div class="col-lg-5">
                    <div class="card"><div class="card-body">
                            <h5 class="card-title">Update Status</h5><hr/>
                            <form action="{{ route('superadmin.commissions.status', $commission) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select mb-3">
                                    @foreach ($statuses as $st)
                                        <option value="{{ $st }}" @selected($commission->status === $st)>{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary w-100">Update</button>
                            </form>
                        </div></div>
                </div>
            </div>

            <a href="{{ route('superadmin.commissions.index') }}" class="btn btn-outline-secondary">Back</a>
        </div></div>
@endsection
