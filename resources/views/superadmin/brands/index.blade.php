@extends('layouts.superadmin.app')

@section('title','Brands')

@section('content')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Brands</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.brands.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Add Brand
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                            <tr>
                                <th style="width:70px">Logo</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:150px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td>
                                        @if ($brand->logo)
                                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="width:45px;height:45px;object-fit:contain;border-radius:6px;" class="border p-1">
                                        @else
                                            <span class="text-muted small">No logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $brand->name }}</td>
                                    <td><span class="text-muted small">{{ $brand->slug }}</span></td>
                                    <td class="text-center">
                                        @if ($brand->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('superadmin.brands.show', $brand->id) }}" class="btn btn-outline-secondary btn-sm" title="View">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('superadmin.brands.edit', $brand->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('superadmin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No brands found. Click "Add Brand" to create one.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
