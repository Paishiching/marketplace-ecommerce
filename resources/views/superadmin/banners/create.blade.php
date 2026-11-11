@extends('layouts.superadmin.app')

@section('title', 'Add Banner')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Marketing</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.banners.index') }}">Banners</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>কিছু ভুল আছে, ঠিক করে আবার submit করুন:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('superadmin.banners._form')
            </form>

        </div>
    </div>
@endsection
