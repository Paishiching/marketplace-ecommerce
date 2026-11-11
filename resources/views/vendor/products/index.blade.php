@extends('layouts.vendor.app')

@section('title', 'My Products')

@section('vendor_content')

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h6 class="mb-0 text-uppercase">My Products</h6>
    <hr/>

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="ms-auto">
                    <a href="{{ route('vendor.products.products.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i> Add Product
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle" style="width:100%">
                    <thead class="table-light">
                    <tr>
                        <th>ID#</th>
                        <th>Thumbnail</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>#{{ $product->id }}</td>
                            <td>
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" width="50" height="50" style="object-fit:cover;border-radius:6px;" alt="">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td>
                                @if ($product->discount_price)
                                    <span class="text-decoration-line-through text-muted">৳{{ number_format($product->price, 2) }}</span>
                                    <span class="text-success ms-1">৳{{ number_format($product->discount_price, 2) }}</span>
                                @else
                                    ৳{{ number_format($product->price, 2) }}
                                @endif
                            </td>
                            <td>
                                @if ($product->status)
                                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Live</div>
                                @else
                                    <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Pending / Inactive</div>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display:flex; flex-direction:row; align-items:center; gap:14px;">
                                    <a href="{{ route('vendor.products.products.edit', $product->id) }}" style="display:flex; align-items:center; line-height:1;">
                                        <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                    </a>
                                    <form action="{{ route('vendor.products.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="margin:0; display:flex; align-items:center;">
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
                        <tr><td colspan="8" class="text-center py-4">Ekhono kono product nei. "Add Product" e click korun.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="mt-3">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
@endsection
