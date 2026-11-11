@extends('layouts.superadmin.app')

@section('title','Vendors')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Marketplace</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vendors</li>
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

            <h6 class="mb-0 text-uppercase">Vendor List</h6>
            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2 mb-4 flex-wrap">
                        <a href="{{ route('superadmin.vendors.index') }}" class="btn btn-sm {{ request('status') ? 'btn-outline-secondary' : 'btn-primary' }}">All</a>
                        @foreach(['pending','approved','suspended'] as $s)
                            <a href="{{ route('superadmin.vendors.index', ['status' => $s]) }}"
                               class="btn btn-sm {{ request('status') === $s ? 'btn-primary' : 'btn-outline-secondary' }}">{{ ucfirst($s) }}</a>
                        @endforeach
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Shop</th>
                                <th>Owner</th>
                                <th>Commission</th>
                                <th>Status</th>
                                <th>Applied</th>
                                <th style="min-width:300px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($vendors as $vendor)
                                @php($owner = $users[$vendor->user_id] ?? null)
                                <tr>
                                    <td>#{{ $vendor->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($vendor->logo)
                                                <img src="{{ asset('storage/' . $vendor->logo) }}" width="40" height="40" style="object-fit:cover;border-radius:6px" alt="">
                                            @endif
                                            <strong>{{ $vendor->shop_name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $owner->name ?? '—' }}<br>
                                        <small class="text-muted">{{ $owner->email ?? '' }}</small>
                                    </td>
                                    <td>{{ $vendor->commission_rate }}%</td>
                                    <td>
                                        @php($map = ['approved' => 'success', 'pending' => 'warning', 'suspended' => 'secondary'])
                                        <div class="badge rounded-pill text-{{ $map[$vendor->status] ?? 'secondary' }} bg-light-{{ $map[$vendor->status] ?? 'secondary' }} p-2 text-uppercase px-3">
                                            {{ $vendor->status }}
                                        </div>
                                    </td>
                                    <td>{{ $vendor->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            @if($vendor->status !== 'approved')
                                                <form action="{{ route('superadmin.vendors.approve', $vendor->id) }}" method="POST" class="d-flex gap-1 m-0">
                                                    @csrf @method('PATCH')
                                                    <input type="number" step="0.01" min="0" max="100" name="commission_rate"
                                                           value="{{ $vendor->commission_rate > 0 ? $vendor->commission_rate : 10 }}"
                                                           class="form-control form-control-sm" style="width:80px" title="Commission %">
                                                    <button class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                            @endif

                                            @if($vendor->status === 'pending')
                                                <form action="{{ route('superadmin.vendors.reject', $vendor->id) }}" method="POST" class="m-0">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-sm btn-danger">Reject</button>
                                                </form>
                                            @endif

                                            @if($vendor->status === 'approved')
                                                <form action="{{ route('superadmin.vendors.suspend', $vendor->id) }}" method="POST" class="m-0"
                                                      onsubmit="return confirm('Suspend korben?');">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-sm btn-warning">Suspend</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center py-4">No vendors found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $vendors->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
