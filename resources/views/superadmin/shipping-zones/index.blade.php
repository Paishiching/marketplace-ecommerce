@extends('layouts.superadmin.app')

@section('title', 'Shipping Zones')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shipping Zones</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.shipping-zones.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add Zone
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
                        ['Total Zones', $stats['total'],    'bx-map-alt',      'primary'],
                        ['Active',      $stats['active'],   'bx-check-circle', 'success'],
                        ['Inactive',    $stats['inactive'], 'bx-x-circle',     'danger'],
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
                    <form method="GET" action="{{ route('superadmin.shipping-zones.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label mb-1">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Zone name..." value="{{ request('search') }}">
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
                            <a href="{{ route('superadmin.shipping-zones.index') }}" class="btn btn-light">Reset</a>
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
                                <th>Regions</th>
                                <th>Rates</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($zones as $zone)
                                <tr>
                                    <td>#{{ $zone->id }}</td>
                                    <td class="fw-bold">{{ $zone->name }}</td>
                                    <td class="small">
                                        @if (!empty($zone->regions))
                                            @foreach (array_slice($zone->regions, 0, 3) as $region)
                                                <span class="badge bg-light text-dark border">{{ $region }}</span>
                                            @endforeach
                                            @if (count($zone->regions) > 3)
                                                <span class="badge bg-light text-dark border">+{{ count($zone->regions) - 3 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($zone->shipping_rates_count) }}</td>
                                    <td>
                                        @if ($zone->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $zone->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('superadmin.shipping-zones.show', $zone) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bx bx-show"></i></a>
                                        <a href="{{ route('superadmin.shipping-zones.edit', $zone) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('superadmin.shipping-zones.destroy', $zone) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('এই zone টি delete করবেন?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bx bx-map-alt fs-1 d-block mb-2"></i>
                                        কোনো shipping zone পাওয়া যায়নি।
                                        <div class="mt-2">
                                            <a href="{{ route('superadmin.shipping-zones.create') }}" class="btn btn-sm btn-primary">Add your first zone</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $zones->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
