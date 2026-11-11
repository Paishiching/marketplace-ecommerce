@extends('layouts.superadmin.app')
@section('title','Wholesale Pricing Tiers')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Wholesale', 'current' => 'Pricing Tiers'])

            <div class="card"><div class="card-body">
                    <form action="{{ route('superadmin.wholesale.tiers.store') }}" method="POST" class="row g-2 mb-4">
                        @csrf
                        <div class="col-md-4">
                            <select name="wholesale_product_id" class="form-select" required>
                                <option value="">Select wholesale product</option>
                                @foreach ($wholesaleProducts as $wp)
                                    <option value="{{ $wp->id }}" @selected(old('wholesale_product_id') == $wp->id)>{{ $wp->product?->name ?? 'Product #' . $wp->product_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2"><input type="number" min="1" name="min_quantity" class="form-control" placeholder="Min qty" value="{{ old('min_quantity') }}" required></div>
                        <div class="col-md-2"><input type="number" min="1" name="max_quantity" class="form-control" placeholder="Max qty (optional)" value="{{ old('max_quantity') }}"></div>
                        <div class="col-md-2"><input type="number" step="0.01" min="0" name="unit_price" class="form-control" placeholder="Unit price" value="{{ old('unit_price') }}" required></div>
                        <div class="col-md-2"><button class="btn btn-primary w-100"><i class="bx bxs-plus-square"></i> Add Tier</button></div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Product</th><th>Min Qty</th><th>Max Qty</th><th>Unit Price</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($tiers as $t)
                                <tr>
                                    <td>#{{ $t->id }}</td>
                                    <td>{{ $t->wholesaleProduct?->product?->name ?? '—' }}</td>
                                    <td>{{ $t->min_quantity }}</td>
                                    <td>{{ $t->max_quantity ?? 'and above' }}</td>
                                    <td>{{ $t->wholesalePrice ? number_format($t->wholesalePrice->unit_price, 2) : '—' }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.wholesale.tiers.destroy', $t) }}" method="POST" class="m-0"
                                              onsubmit="return confirm('Delete this tier?');">
                                            @csrf @method('DELETE')
                                            <button class="border-0 bg-transparent p-0"><i class='bx bxs-trash' style="font-size:20px;color:#e74c3c;"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4">No pricing tiers found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $tiers->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
