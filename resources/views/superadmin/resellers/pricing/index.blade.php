@extends('layouts.superadmin.app')
@section('title','Reseller Pricing')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Resellers', 'current' => 'Pricing'])

            <div class="card"><div class="card-body">
                    <form method="GET" class="row g-2 mb-4">
                        <div class="col-md-3">
                            <select name="reseller_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Resellers</option>
                                @foreach ($resellers as $r)
                                    <option value="{{ $r->id }}" @selected(request('reseller_id') == $r->id)>{{ $r->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th><th>Reseller</th><th>Product</th><th>Base Price</th>
                                <th style="width:180px">Selling Price</th><th>Margin</th><th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                @php
                                    $base    = $item->product?->price ?? 0;
                                    $selling = $item->price?->selling_price;
                                    $margin  = $selling !== null ? $selling - $base : null;
                                @endphp
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>{{ $item->reseller?->business_name ?? '—' }}</td>
                                    <td>{{ $item->product?->name ?? '—' }}</td>
                                    <td>{{ number_format($base, 2) }}</td>
                                    <td>
                                        <input type="number" step="0.01" min="0" name="selling_price"
                                               form="price-{{ $item->id }}" value="{{ $selling }}"
                                               class="form-control form-control-sm" required>
                                    </td>
                                    <td class="{{ $margin !== null && $margin < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $margin !== null ? number_format($margin, 2) : '—' }}
                                    </td>
                                    <td>
                                        <form id="price-{{ $item->id }}" action="{{ route('superadmin.reseller.pricing.update', $item) }}" method="POST" class="m-0">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-primary">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center py-4">No reseller products found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $items->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
