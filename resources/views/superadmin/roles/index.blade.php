@extends('layouts.superadmin.app')

@section('title','Roles')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Roles</li>
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

            <h6 class="mb-0 text-uppercase">Role List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <a href="{{ route('superadmin.roles.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                <i class="bx bxs-plus-square"></i> Add Role
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Users</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $role->name }}</td>
                                    <td>{{ $role->users_count }}</td>
                                    <td>
                                        @if ($role->name === $superRole)
                                            <span class="badge bg-success">Full Access</span>
                                        @else
                                            {{ $role->permissions_count }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($role->name === $superRole)
                                            <span class="text-muted">System role</span>
                                        @else
                                            <div style="display:flex; align-items:center; gap:14px;">
                                                <a href="{{ route('superadmin.roles.edit', $role->id) }}">
                                                    <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                                </a>
                                                <form action="{{ route('superadmin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Delete this role?');" style="margin:0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent p-0">
                                                        <i class='bx bxs-trash' style="font-size:20px; color:#e74c3c;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No roles found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection