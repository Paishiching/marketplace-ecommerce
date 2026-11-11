@extends('layouts.superadmin.app')

@section('title', $cfg['title'])

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Marketplace</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $cfg['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <h6 class="mb-0 text-uppercase">{{ $cfg['title'] }} List</h6>
            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2 mb-4 flex-wrap">
                        <a href="{{ route($cfg['prefix'] . '.index') }}" class="btn btn-sm {{ request('status') ? 'btn-outline-secondary' : 'btn-primary' }}">All</a>
                        @foreach(['pending','approved','rejected','suspended'] as $s)
                            <a href="{{ route($cfg['prefix'] . '.index', ['status' => $s]) }}"
                               class="btn btn-sm {{ request('status') === $s ? 'btn-primary' : 'btn-outline-secondary' }}">{{ ucfirst($s) }}</a>
                        @endforeach
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Name</th>
                                <th>Owner</th>
                                @if($cfg['rate'])<th>{{ $cfg['rate_label'] }}</th>@endif
                                <th>Status</th>
                                <th>Applied</th>
                                <th style="min-width:280px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                @php
                                    $owner = $users[$item->user_id] ?? null;
                                    $map = ['approved' => 'success', 'pending' => 'warning', 'suspended' => 'secondary', 'rejected' => 'danger'];
                                    $rateVal = $cfg['rate'] ? $item->{$cfg['rate']} : null;
                                @endphp
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td><strong>{{ $item->{$cfg['name']} }}</strong></td>
                                    <td>
                                        {{ $owner->name ?? '—' }}<br>
                                        <small class="text-muted">{{ $owner->email ?? '' }}</small>
                                    </td>
                                    @if($cfg['rate'])<td>{{ $rateVal }}%</td>@endif
                                    <td>
                                        <div class="badge rounded-pill text-{{ $map[$item->status] ?? 'secondary' }} bg-light-{{ $map[$item->status] ?? 'secondary' }} p-2 text-uppercase px-3">
                                            {{ $item->status }}
                                        </div>
                                    </td>
                                    <td>{{ $item->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            @if($item->status !== 'approved')
                                                <form action="{{ route($cfg['prefix'] . '.approve', $item->id) }}" method="POST" class="d-flex gap-1 m-0">
                                                    @csrf @method('PATCH')
                                                    @if($cfg['rate'])
                                                        <input type="number" step="0.01" min="0" max="100" name="rate"
                                                               value="{{ $rateVal > 0 ? $rateVal : 10 }}"
                                                               class="form-control form-control-sm" style="width:80px" title="{{ $cfg['rate_label'] }}">
                                                    @endif
                                                    <button class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                            @endif

                                            @if($item->status === 'pending')
                                                <form action="{{ route($cfg['prefix'] . '.reject', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Reject this application?');">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-sm btn-outline-danger">Reject</button>
                                                </form>
                                            @endif

                                            @if($item->status === 'approved')
                                                <form action="{{ route($cfg['prefix'] . '.suspend', $item->id) }}" method="POST" class="m-0"
                                                      onsubmit="return confirm('Suspend this account?');">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-sm btn-warning">Suspend</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4">No partner accounts found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
