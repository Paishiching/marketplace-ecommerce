@extends('layouts.vendor.app')

@section('title', 'Add Product')

@section('vendor_content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendor.products.products.index') }}">My Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('vendor.products.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @include('vendor.products._form', ['product' => null])
    </form>
@endsection
