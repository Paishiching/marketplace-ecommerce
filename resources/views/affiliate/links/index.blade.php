@extends('layouts.affiliate.app')

@section('title', 'My Links')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">My Links</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('affiliate.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Links</li>
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

            <h6 class="mb-0 text-uppercase">Affiliate Link List</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <a href="{{ route('affiliate.links.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                                <i class="bx bxs-plus-square"></i> Create Link
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Product</th>
                                <th>Your Link</th>
                                <th>Clicks</th>
                                <th>Sales</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($links as $link)
                                <tr id="link-{{ $link->id }}">
                                    <td>#{{ $link->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($link->product && $link->product->thumbnail)
                                                <img src="{{ asset('storage/' . $link->product->thumbnail) }}" alt="{{ $link->product->name }}" width="40" height="40" style="object-fit:cover;border-radius:6px;">
                                            @endif
                                            <span>{{ $link->product->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php $shortUrl = url('/ref/' . $link->code); @endphp
                                        <div class="input-group input-group-sm" style="min-width:240px;">
                                            <input type="text" class="form-control" value="{{ $shortUrl }}" readonly>
                                            <button type="button" class="btn btn-outline-primary copy-btn" data-url="{{ $shortUrl }}">Copy</button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($link->clicks_count) }}</td>
                                    <td>{{ $link->sales_count }}</td>
                                    <td>
                                        @if ($link->is_active)
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Active</div>
                                        @else
                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Inactive</div>
                                        @endif
                                    </td>
                                    <td>{{ $link->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('affiliate.links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this link?');" style="margin:0; display:flex; align-items:center;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent p-0" style="display:flex; align-items:center; line-height:1;">
                                                <i class='bx bxs-trash' style="font-size:20px; color:#e74c3c;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No links yet. Create your first link.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            if (typeof $ !== 'undefined' && $.fn.DataTable) {
                if ($.fn.DataTable.isDataTable('#example')) {
                    $('#example').DataTable().destroy();
                }
                $('#example').DataTable({
                    order: [],
                    columnDefs: [{ orderable: false, targets: [2, 7] }]
                });
            }

            // Copy button
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.copy-btn');
                if (!btn) return;

                navigator.clipboard.writeText(btn.dataset.url).then(function () {
                    var old = btn.textContent;
                    btn.textContent = 'Copied!';
                    setTimeout(function () { btn.textContent = old; }, 1500);
                });
            });
        });
    </script>
@endsection
