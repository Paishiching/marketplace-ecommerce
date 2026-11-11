@extends('layouts.superadmin.app')
@section('title','Wholesale Products')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Wholesale', 'current' => 'Products'])

            <div class="card"><div class="card-body">
                    <form action="{{ route('superadmin.wholesale.products.store') }}" method="POST" class="row g-2 mb-4">
                        @csrf
                        <div class="col-md-6">
                            <select name="product_id" class="form-select" required>
                                <option value="">Select product to add to wholesale</option>
                                @foreach ($availableProducts as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3"><button class="btn btn-primary"><i class="bx bxs-plus-square"></i> Add Product</button></div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Product</th><th>Price</th><th>Wholesale</th><th>Date</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>{{ $item->product?->name ?? '—' }}</td>
                                    <td>{{ $item->product?->price !== null ? number_format($item->product->price, 2) : '—' }}</td>
                                    <td>@include('superadmin.partials.status-badge', ['status' => $item->is_wholesale_enabled])</td>
                                    <td>{{ $item->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('superadmin.wholesale.products.toggle', $item) }}" method="POST" class="m-0">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm {{ $item->is_wholesale_enabled ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                                    {{ $item->is_wholesale_enabled ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('superadmin.wholesale.products.destroy', $item) }}" method="POST" class="m-0"
                                                  onsubmit="return confirm('Remove this product from wholesale?');">
                                                @csrf @method('DELETE')
                                                <button class="border-0 bg-transparent p-0"><i class='bx bxs-trash' style="font-size:20px;color:#e74c3c;"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4">No wholesale products found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $items->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
