@extends('layouts.superadmin.app')
@section('title','Commission Rules')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Finance', 'current' => 'Commission Rules'])

            <div class="card"><div class="card-body">
                    <form action="{{ route('superadmin.commission-rules.store') }}" method="POST" class="row g-2 mb-2">
                        @csrf
                        <div class="col-md-4">
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="vendor_id" class="form-select">
                                <option value="">All Vendors</option>
                                @foreach ($vendors as $v)
                                    <option value="{{ $v->id }}">{{ $v->shop_name ?? $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2"><input type="number" step="0.01" min="0" max="100" name="commission_percent" class="form-control" placeholder="Percent %" required></div>
                        <div class="col-md-2"><button class="btn btn-primary w-100">Save Rule</button></div>
                    </form>
                    <small class="text-muted d-block mb-4">Category ba Vendor khali rakhle "sobar jonno" hishebe dhora hobe. Same combination age theke thakle update hobe.</small>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>ID#</th><th>Category</th><th>Vendor</th><th style="width:220px">Percent %</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($rules as $r)
                                <tr>
                                    <td>#{{ $r->id }}</td>
                                    <td>{{ $r->category?->name ?? 'All' }}</td>
                                    <td>{{ $r->vendor?->shop_name ?? $r->vendor?->name ?? 'All' }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.commission-rules.update', $r) }}" method="POST" class="d-flex gap-2 m-0">
                                            @csrf @method('PUT')
                                            <input type="number" step="0.01" min="0" max="100" name="commission_percent" value="{{ $r->commission_percent }}" class="form-control form-control-sm">
                                            <button class="btn btn-sm btn-primary">Save</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('superadmin.commission-rules.destroy', $r) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this rule?');">
                                            @csrf @method('DELETE')
                                            <button class="border-0 bg-transparent p-0"><i class='bx bxs-trash' style="font-size:20px;color:#e74c3c;"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No commission rules found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $rules->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection
