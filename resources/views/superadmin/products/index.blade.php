@extends('layouts.superadmin.app')

@section('title','Products')

@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Products</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h6 class="mb-0 text-uppercase">Product List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('superadmin.products.index') }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-outline-secondary' : 'btn-primary' }}">All</a>
                            <a href="{{ route('superadmin.products.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }}">Pending Approval</a>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('superadmin.products.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                <i class="bx bxs-plus-square"></i> Add Product
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Thumbnail</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>View Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                <tr id="product-{{ $product->id }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input me-3" type="checkbox" value="{{ $product->id }}" aria-label="...">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0 font-14">#{{ $product->id }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" width="50" height="50" style="object-fit:cover;border-radius:6px;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '—' }}</td>
                                    <td>{{ $product->brand->name ?? '—' }}</td>
                                    <td>
                                        @if ($product->discount_price)
                                            <span class="text-decoration-line-through text-muted">৳{{ number_format($product->price, 2) }}</span>
                                            <span class="text-success ms-1">৳{{ number_format($product->discount_price, 2) }}</span>
                                        @else
                                            ৳{{ number_format($product->price, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badge = ['published' => 'success', 'pending' => 'warning', 'rejected' => 'danger', 'draft' => 'secondary'][$product->status] ?? 'secondary';
                                        @endphp
                                        <div class="badge rounded-pill text-{{ $badge }} bg-light-{{ $badge }} p-2 text-uppercase px-3">
                                            <i class='bx bxs-circle me-1'></i>{{ $product->status }}
                                        </div>
                                    </td>
                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.products.show', $product->id) }}" class="btn btn-primary radius-30" style="font-size:12px; padding:4px 12px;">View</a>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:row; align-items:center; gap:14px;">
                                                                                     @if ($product->status === 'pending')
                                                <form action="{{ route('superadmin.products.approve', $product->id) }}" method="POST" style="margin:0;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" style="padding:2px 10px;">Approve</button>
                                                </form>
                                                <form action="{{ route('superadmin.products.reject', $product->id) }}" method="POST" style="margin:0;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="padding:2px 10px;">Reject</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('superadmin.products.edit', $product->id) }}" style="display:flex; align-items:center; line-height:1;">
                                                <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                            </a>
                                            <form action="{{ route('superadmin.products.destroy', $product->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this product?');" style="margin:0; display:flex; align-items:center;">
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
                                <tr>
                                    <td colspan="10" class="text-center py-4">No products found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->

    <style>
        tr.row-highlight td {
            background-color: #fff3cd !important;
            transition: background-color 1s ease;
        }
    </style>

    <script>
        // window load: template-এর সব script (jQuery, DataTable) load হওয়ার পর চলবে
        window.addEventListener('load', function () {
            if (typeof $ === 'undefined' || !$.fn.DataTable) return;

            // template আগে init করে থাকলে destroy করে নতুন করে init
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            var table = $('#example').DataTable({
                order: [],                       // নিজে sort করবে না, Laravel-এর order (নতুন আগে) থাকবে
                columnDefs: [
                    { orderable: false, targets: [1, 8, 9] }
                ]
            });

            // update-এর পর ওই product-এর row-এর page-এ যাও, scroll + highlight
            var hash = window.location.hash;
            if (hash && hash.indexOf('#product-') === 0) {
                var rowId = hash.substring(1);
                var nodes = table.rows({ order: 'current', search: 'applied' }).nodes().toArray();
                var index = nodes.findIndex(function (n) { return n.id === rowId; });

                if (index !== -1) {
                    table.page(Math.floor(index / table.page.len())).draw('page');

                    var row = document.getElementById(rowId);
                    if (row) {
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        row.classList.add('row-highlight');
                        setTimeout(function () {
                            row.classList.remove('row-highlight');
                        }, 3000);
                    }
                }
            }
        });
    </script>
@endsection
