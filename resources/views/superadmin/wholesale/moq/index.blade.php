@extends('layouts.superadmin.app')
@section('title','Minimum Order Quantity')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Wholesale', 'current' => 'Min. Order Qty'])

            <div class="card"><div class="card-body">
                    <form action="{{ route('superadmin.wholesale.moq.store') }}" method="POST" class="row g-2 mb-4">
                        @csrf
                        <div class="col-md-5">
                            <select name="wholesale_product_id" class="form-select" required>
                                <option value="">Select wholesale product</option>
                                @foreach ($wholesaleProducts as $wp)
                                    <option value="{{ $wp->id }}">{{ $wp->product?->name ?? 'Product #' . $wp->product_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3"><input type="number" min="1" name="moq" class="form-control" placeholder="Minimum quantity" required></div>
                        <div class="col-md-2"><button class="btn btn-primary w-100">Save</button></div>
                    </form>
                    <small class="text-muted d-block mb-3">Same product-er MOQ age theke thakle update hobe.</small>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Product</th><th>MOQ</th><th>Updated</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $m)
                                <tr>
                                    <td>#{{ $m->id }}</td>
                                    <td>{{ $m->wholesaleProduct?->product?->name ?? '—' }}</td>
                                    <td>{{ $m->moq }}</td>
                                    <td>{{ $m->updated_at?->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.wholesale.moq.destroy', $m) }}" method="POST" class="m-0"
                                              onsubmit="return confirm('Remove this MOQ?');">
                                            @csrf @method('DELETE')
                                            <button class="border-0 bg-transparent p-0"><i class='bx bxs-trash' style="font-size:20px;color:#e74c3c;"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No MOQ rules found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $items->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
