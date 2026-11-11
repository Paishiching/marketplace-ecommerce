@extends('layouts.superadmin.app')

@section('title','Warranty Registrations')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Warranty</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Warranty Registrations</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h6 class="mb-0 text-uppercase">Warranty List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <a href="{{ route('superadmin.warranties.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                <i class="bx bxs-plus-square"></i> Add Warranty
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Serial Number</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Purchase Date</th>
                                <th>Warranty</th>
                                <th>Expires At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($warranties as $warranty)
                                <tr id="warranty-{{ $warranty->id }}">
                                    <td><h6 class="mb-0 font-14">#{{ $warranty->id }}</h6></td>
                                    <td><strong>{{ $warranty->serial_number }}</strong></td>
                                    <td>{{ $warranty->product_name ?: '—' }}</td>
                                    <td>{{ $warranty->customer_name ?: '—' }}</td>
                                    <td>{{ $warranty->phone ?: '—' }}</td>
                                    <td data-order="{{ $warranty->purchase_date->format('Y-m-d') }}">{{ $warranty->purchase_date->format('M d, Y') }}</td>
                                    <td>{{ $warranty->warranty_months }} months</td>
                                    <td data-order="{{ $warranty->expires_at->format('Y-m-d') }}">{{ $warranty->expires_at->format('M d, Y') }}</td>
                                    <td>
                                        @if ($warranty->is_active)
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Active</div>
                                        @else
                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Expired</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:row; align-items:center; gap:14px;">
                                            <a href="{{ route('superadmin.warranties.edit', $warranty->id) }}" style="display:flex; align-items:center; line-height:1;">
                                                <i class='bx bxs-edit' style="font-size:20px; color:#6c5ce7;"></i>
                                            </a>
                                            <form action="{{ route('superadmin.warranties.destroy', $warranty->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this warranty record?');" style="margin:0; display:flex; align-items:center;">
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
                                    <td colspan="10" class="text-center py-4">No warranty records found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        tr.row-highlight td {
            background-color: #fff3cd !important;
            transition: background-color 1s ease;
        }
    </style>

    <script>
        window.addEventListener('load', function () {
            if (typeof $ === 'undefined' || !$.fn.DataTable) return;

            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            var table = $('#example').DataTable({
                order: [],
                columnDefs: [
                    { orderable: false, targets: [9] }
                ]
            });

            // update-er por oi row te giye highlight
            var hash = window.location.hash;
            if (hash && hash.indexOf('#warranty-') === 0) {
                var rowId = hash.substring(1);
                var nodes = table.rows({ order: 'current', search: 'applied' }).nodes().toArray();
                var index = nodes.findIndex(function (n) { return n.id === rowId; });

                if (index !== -1) {
                    table.page(Math.floor(index / table.page.len())).draw('page');

                    var row = document.getElementById(rowId);
                    if (row) {
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        row.classList.add('row-highlight');
                        setTimeout(function () { row.classList.remove('row-highlight'); }, 3000);
                    }
                }
            }
        });
    </script>
@endsection