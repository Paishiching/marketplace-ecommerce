@extends('layouts.superadmin.app')

@section('title', 'Couriers')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Couriers</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.couriers.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add Courier
                    </a>
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

            {{-- STATS --}}
            <div class="row row-cols-1 row-cols-md-3 mb-3">
                @php
                    $cards = [
                        ['Total Couriers', $stats['total'],    'bx-car',          'primary'],
                        ['Active',         $stats['active'],   'bx-check-circle', 'success'],
                        ['Inactive',       $stats['inactive'], 'bx-x-circle',     'danger'],
                    ];
                @endphp
                @foreach ($cards as [$label, $count, $icon, $color])
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-4 border-{{ $color }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">{{ $label }}</p>
                                        <h4 class="my-1">{{ number_format($count) }}</h4>
                                    </div>
                                    <div class="ms-auto fs-1 text-{{ $color }}"><i class="bx {{ $icon }}"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- FILTERS --}}
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('superadmin.couriers.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label mb-1">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Courier name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary flex-fill" type="submit"><i class="bx bx-filter-alt"></i> Filter</button>
                            <a href="{{ route('superadmin.couriers.index') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Tracking URL</th>
                                <th>Shipments</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($couriers as $courier)
                                <tr>
                                    <td>#{{ $courier->id }}</td>
                                    <td class="fw-bold">{{ $courier->name }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $courier->driver_label }}</span></td>
                                    <td class="small">
                                        @if ($courier->tracking_url)
                                            <a href="{{ $courier->tracking_url }}" target="_blank" rel="noopener" class="text-truncate d-inline-block" style="max-width:220px;">
                                                {{ $courier->tracking_url }}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($courier->shipments_count) }}</td>
                                    <td>
                                        @if ($courier->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $courier->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('superadmin.couriers.show', $courier) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bx bx-show"></i></a>
                                        <a href="{{ route('superadmin.couriers.edit', $courier) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('superadmin.couriers.destroy', $courier) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('এই courier টি delete করবেন?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-car fs-1 d-block mb-2"></i>
                                        কোনো courier পাওয়া যায়নি।
                                        <div class="mt-2">
                                            <a href="{{ route('superadmin.couriers.create') }}" class="btn btn-sm btn-primary">Add your first courier</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $couriers->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
