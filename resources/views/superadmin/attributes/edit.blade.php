@extends('layouts.superadmin.app')

@section('title','Edit Attribute')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Edit Attribute</h5>
                    <hr/>
                    <form action="{{ route('superadmin.attributes.update', $attribute) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Attribute Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $attribute->name) }}" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
