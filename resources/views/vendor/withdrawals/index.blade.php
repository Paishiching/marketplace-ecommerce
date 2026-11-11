@extends('layouts.superadmin.app')

@section('title', 'Withdrawals')

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Finance</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Withdrawals</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="card-title">Request Withdraw</h5>
                            <hr/>

                            <div class="alert alert-success py-2">
                                Available: <strong>৳{{ number_format($wallet['available'], 2) }}</strong>
                            </div>

                            <form action="{{ route('vendor.finance.withdrawals.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Amount (৳) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="{{ $minimum }}" max="{{ $wallet['available'] }}" name="amount"
                                           value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" required>
                                    <small class="text-muted">Minimum ৳{{ number_format($minimum) }}</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Method <span class="text-danger">*</span></label>
                                    <select name="method" class="form-select @error('method') is-invalid @enderror" required>
                                        @foreach ($methods as $m)
                                            <option value="{{ $m }}" @selected(old('method') === $m)>{{ $m }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Details <span class="text-danger">*</span></label>
                                    <textarea name="account_details" rows="3" maxlength="500"
                                              class="form-control @error('account_details') is-invalid @enderror"
                                              placeholder="bKash/Nagad number, ba Bank name + account no" required>{{ old('account_details') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" @disabled($wallet['available'] < $minimum)>
                                    <i class="bx bx-send"></i> Submit Request
                                </button>
                                @if ($wallet['available'] < $minimum)
                                    <small class="text-muted d-block mt-2">Available balance ৳{{ number_format($minimum) }} er kom, tai request deya jacche na.</small>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">My Withdrawal Requests</h5>
                            <hr/>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th class="text-end">Amount</th>
                                        <th>Method</th>
                                        <th>Account</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($withdrawals as $w)
                                        @php
                                            $color = ['paid' => 'success', 'approved' => 'info', 'pending' => 'warning', 'rejected' => 'danger'][$w->status] ?? 'secondary';
                                        @endphp
                                        <tr>
                                            <td>{{ $w->id }}</td>
                                            <td>{{ $w->created_at->format('M d, Y') }}</td>
                                            <td class="text-end">৳{{ number_format($w->amount, 2) }}</td>
                                            <td>{{ $w->method }}</td>
                                            <td class="small">{{ $w->account_details }}</td>
                                            <td>
                                                <div class="badge rounded-pill text-{{ $color }} bg-light-{{ $color }} p-2 text-uppercase px-3">{{ $w->status }}</div>
                                            </td>
                                            <td class="small">{{ $w->note ?: '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center py-4">Kono request nai.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $withdrawals->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection