@extends('layouts.affiliate.app')

@section('title', 'Create Link')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">My Links</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('affiliate.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Link</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('affiliate.links.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Link Information</h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Select Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                        <option value="">-- Choose a product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id', $selectedProduct) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (৳{{ number_format($product->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <small class="text-muted">Save korle apnar jonno ekta unique tracking link toiri hobe.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('affiliate.links.index') }}" class="btn btn-outline-secondary btn-lg w-50">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">Create Link</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
