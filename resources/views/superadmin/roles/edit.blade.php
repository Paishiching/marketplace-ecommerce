@extends('layouts.superadmin.app')

@section('title','Edit Role')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Roles</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.roles.index') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <form action="{{ route('superadmin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('superadmin.roles._form', ['submit' => 'Update Role'])
            </form>
        </div>
    </div>
@endsection