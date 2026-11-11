@extends('layouts.superadmin.app')

@section('title','Resellers')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Resellers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Resellers</li>
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

            <h6 class="mb-0 text-uppercase">Reseller List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('superadmin.resellers.index') }}" method="GET" class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="d-flex gap-2 flex-wrap">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by business, owner name or email" style="min-width:280px;">

                            <select name="status" class="form-select" style="min-width:160px;">
                                <option value="">All Status</option>
                                <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                                <option value="approved" @selected(request('status') == 'approved')>Approved</option>
                                <option value="suspended" @selected(request('status') == 'suspended')>Suspended</option>
                            </select>

                            <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i> Filter</button>
                            @if (request('search') || request('status'))
                                <a href="{{ route('superadmin.resellers.index') }}" class="btn btn-outline-secondary"><i class="bx bx-x"></i> Reset</a>
                            @endif
                        </div>

                        <div class="ms-auto mt-2 mt-lg-0">
                            <a href="{{ route('superadmin.resellers.create') }}" class="btn btn-primary radius-30">
                                <i class="bx bxs-plus-square"></i> Add Reseller
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Business</th>
                                <th>Owner</th>
                                <th>Markup</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>View Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($resellers as $reseller)
                                <tr>
                                    <td><h6 class="mb-0 font-14">#{{ $reseller->id }}</h6></td>
                                    <td class="fw-semibold">{{ $reseller->business_name }}</td>
                                    <td>
                                        <div>{{ $reseller->user->name ?? '—' }}</div>
                                        <small class="text-muted">{{ $reseller->user->email ?? '' }}</small>
                                    </td>
                                    <td>{{ $reseller->markup_rate !== null ? rtrim(rtrim(number_format($reseller->markup_rate, 2), '0'), '.') . '%' : '—' }}</td>
                                    <td>
                                        @if ($reseller->status === 'approved')
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Approved</div>
                                        @elseif ($reseller->status === 'suspended')
                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Suspended</div>
                                        @else
                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Pending</div>
                                        @endif
                                    </td>
                                    <td>{{ $reseller->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.resellers.show', $reseller->id) }}" class="btn btn-primary radius-30" style="font-size:12px; padding:4px 12px;">View</a>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:row; align-items:center; gap:14px;">

                                            @if ($reseller->status !== 'approved')
                                                <form action="{{ route('superadmin.resellers.approve', $reseller->id) }}" method="POST" style="margin:0; display:flex; align-items:center;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="border-0 bg-transparent p-0" title="Approve" style="display:flex; align-items:center; line-height:1;">
                                                        <i class='bx bxs-check-circle' style="font-size:20px; color:#28a745;"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('superadmin.resellers.suspend', $reseller->id) }}" method="POST" onsubmit="return confirm('Suspend this reseller?');" style="margin:0; display:flex; align-items:center;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="border-0 bg-transparent p-0" title="Suspend" style="display:flex; align-items:center; line-height:1;">
                                                        <i class='bx bxs-error-circle' style="font-size:20px; color:#f39c12;"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('superadmin.resellers.edit', $reseller->id) }}" title="Edit" style="display:flex; align-items:center; line-height:1;">
                                                <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                            </a>
                                            <form action="{{ route('superadmin.resellers.destroy', $reseller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reseller?');" style="margin:0; display:flex; align-items:center;">
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
                                    <td colspan="8" class="text-center py-4">No resellers found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $resellers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
