@extends('layouts.superadmin.app')

@section('title','Add Attribute')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New Attribute</h5>
                    <hr/>
                    <form action="{{ route('superadmin.attributes.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Attribute Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Color, Size, Material" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
