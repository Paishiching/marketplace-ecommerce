@extends('layouts.superadmin.app')

@section('title','Attributes')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Catalog</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Attributes (Color, Size, etc.)</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">All Attributes</h5>
                        <a href="{{ route('superadmin.attributes.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New Attribute
                        </a>
                    </div>
                    <hr/>

                    @foreach($attributes as $attribute)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $attribute->name }}</h6>
                                <div>
                                    <a href="{{ route('superadmin.attributes.edit', $attribute) }}" class="btn btn-sm btn-outline-secondary">Rename</a>
                                    <form action="{{ route('superadmin.attributes.destroy', $attribute) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this attribute and all its values?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-3">
                                @foreach($attribute->attributeValues as $value)
                                    <span class="badge bg-light text-dark border me-1 mb-1 p-2">
                                    {{ $value->value }}
                                    <form action="{{ route('superadmin.attributes.values.destroy', $value) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this value?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-1" style="text-decoration:none;">&times;</button>
                                    </form>
                                </span>
                                @endforeach
                            </div>

                            <form action="{{ route('superadmin.attributes.values.store', $attribute) }}" method="POST" class="d-flex gap-2 mt-3">
                                @csrf
                                <input type="text" name="value" class="form-control form-control-sm w-auto" placeholder="e.g. Red / M / Cotton" required>
                                <button type="submit" class="btn btn-sm btn-primary">Add Value</button>
                            </form>
                        </div>
                    @endforeach

                    @if($attributes->isEmpty())
                        <p class="text-muted">No attributes yet. Click "Add New Attribute" to create Color, Size, etc.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
