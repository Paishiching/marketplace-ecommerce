@extends('layouts.superadmin.app')

@section('title', 'Delivery Rates')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Delivery</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Delivery Rates</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.delivery-rates.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add Rate
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
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                @php
                    $cards = [
                        ['Total Rates', $stats['total'], 'bx-purchase-tag-alt', 'primary'],
                        ['Total Zones', $stats['zones'], 'bx-map-alt',          'info'],
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
                    <form method="GET" action="{{ route('superadmin.delivery-rates.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label mb-1">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Rate name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1">Zone</label>
                            <select name="zone" class="form-select">
                                <option value="">All Zones</option>
                                @foreach ($zones as $z)
                                    <option value="{{ $z->id }}" {{ (string) request('zone') === (string) $z->id ? 'selected' : '' }}>{{ $z->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary flex-fill" type="submit"><i class="bx bx-filter-alt"></i> Filter</button>
                            <a href="{{ route('superadmin.delivery-rates.index') }}" class="btn btn-light">Reset</a>
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
                                <th>Zone</th>
                                <th>Rate</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($rates as $rate)
                                <tr>
                                    <td>#{{ $rate->id }}</td>
                                    <td class="fw-bold">{{ $rate->name }}</td>
                                    <td>{{ $rate->shippingZone->name ?? '—' }}</td>
                                    <td>{{ number_format($rate->rate, 2) }}</td>
                                    <td class="small text-muted">{{ $rate->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('superadmin.delivery-rates.show', $rate) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bx bx-show"></i></a>
                                        <a href="{{ route('superadmin.delivery-rates.edit', $rate) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('superadmin.delivery-rates.destroy', $rate) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('এই rate টি delete করবেন?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bx bx-purchase-tag-alt fs-1 d-block mb-2"></i>
                                        কোনো delivery rate পাওয়া যায়নি।
                                        <div class="mt-2">
                                            <a href="{{ route('superadmin.delivery-rates.create') }}" class="btn btn-sm btn-primary">Add your first rate</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $rates->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
