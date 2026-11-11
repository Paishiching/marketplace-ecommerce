@extends('layouts.superadmin.app')

@section('title','Affiliates')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Affiliates</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Affiliates</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <h6 class="mb-0 text-uppercase">Affiliate List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('superadmin.affiliates.index') }}" method="GET" class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="d-flex gap-2 flex-wrap">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, email or referral code" style="min-width:280px;">

                            <select name="status" class="form-select" style="min-width:160px;">
                                <option value="">All Status</option>
                                <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                                <option value="approved" @selected(request('status') == 'approved')>Approved</option>
                                <option value="suspended" @selected(request('status') == 'suspended')>Suspended</option>
                            </select>

                            <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i> Filter</button>
                            @if (request('search') || request('status'))
                                <a href="{{ route('superadmin.affiliates.index') }}" class="btn btn-outline-secondary"><i class="bx bx-x"></i> Reset</a>
                            @endif
                        </div>

                        <div class="ms-auto mt-2 mt-lg-0">
                            <a href="{{ route('superadmin.affiliates.create') }}" class="btn btn-primary radius-30">
                                <i class="bx bxs-plus-square"></i> Add Affiliate
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Affiliate</th>
                                <th>Referral Code</th>
                                <th>Commission</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>View Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($affiliates as $affiliate)
                                <tr>
                                    <td><h6 class="mb-0 font-14">#{{ $affiliate->id }}</h6></td>
                                    <td>
                                        <div class="fw-semibold">{{ $affiliate->user->name ?? '—' }}</div>
                                        <small class="text-muted">{{ $affiliate->user->email ?? '' }}</small>
                                    </td>
                                    <td><code>{{ $affiliate->referral_code }}</code></td>
                                    <td>{{ $affiliate->commission_rate !== null ? rtrim(rtrim(number_format($affiliate->commission_rate, 2), '0'), '.') . '%' : '—' }}</td>
                                    <td>
                                        @if ($affiliate->status === 'approved')
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Approved</div>
                                        @elseif ($affiliate->status === 'suspended')
                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Suspended</div>
                                        @else
                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Pending</div>
                                        @endif
                                    </td>
                                    <td>{{ $affiliate->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.affiliates.show', $affiliate->id) }}" class="btn btn-primary radius-30" style="font-size:12px; padding:4px 12px;">View</a>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:row; align-items:center; gap:14px;">

                                            @if ($affiliate->status !== 'approved')
                                                <form action="{{ route('superadmin.affiliates.approve', $affiliate->id) }}" method="POST" style="margin:0; display:flex; align-items:center;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="border-0 bg-transparent p-0" title="Approve" style="display:flex; align-items:center; line-height:1;">
                                                        <i class='bx bxs-check-circle' style="font-size:20px; color:#28a745;"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('superadmin.affiliates.suspend', $affiliate->id) }}" method="POST" onsubmit="return confirm('Suspend this affiliate?');" style="margin:0; display:flex; align-items:center;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="border-0 bg-transparent p-0" title="Suspend" style="display:flex; align-items:center; line-height:1;">
                                                        <i class='bx bxs-error-circle' style="font-size:20px; color:#f39c12;"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('superadmin.affiliates.edit', $affiliate->id) }}" title="Edit" style="display:flex; align-items:center; line-height:1;">
                                                <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                            </a>
                                            <form action="{{ route('superadmin.affiliates.destroy', $affiliate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this affiliate?');" style="margin:0; display:flex; align-items:center;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete" style="display:flex; align-items:center; line-height:1;">
                                                    <i class='bx bxs-trash' style="font-size:20px; color:#e74c3c;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No affiliates found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $affiliates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
