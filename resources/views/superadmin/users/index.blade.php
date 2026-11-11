@extends('layouts.superadmin.app')

@section('title','Users')

@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h6 class="mb-0 text-uppercase">User List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                <i class="bx bxs-plus-square"></i> Add User
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>View Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input me-3" type="checkbox" value="{{ $user->id }}" aria-label="...">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0 font-14">#{{ $user->id }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" width="45" height="45" style="object-fit:cover;border-radius:50%;">
                                        @else
                                            <img src="{{ asset('images/default-avatar.png') }}" alt="{{ $user->name }}" width="45" height="45" style="object-fit:cover;border-radius:50%;">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '—' }}</td>
                                    <td>
                                        @forelse ($user->roles as $r)
                                            <span class="badge bg-primary text-capitalize">{{ $r->name }}</span>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @if ($user->status)
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Active</div>
                                        @else
                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Inactive</div>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.users.show', $user->id) }}" class="btn btn-primary radius-30" style="font-size:12px; padding:4px 12px;">View</a>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:row; align-items:center; gap:14px;">
                                            <a href="{{ route('superadmin.users.edit', $user->id) }}" style="display:flex; align-items:center; line-height:1;">
                                                <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                            </a>
                                            <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this user?');" style="margin:0; display:flex; align-items:center;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent p-0" style="display:flex; align-items:center; line-height:1;">
                                                    <i class='bx bxs-trash' style="font-size:20px; color:#e74c3c;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">No users found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection