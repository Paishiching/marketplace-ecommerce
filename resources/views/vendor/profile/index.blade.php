@extends('layouts.superadmin.app')

@section('title', 'My Profile')

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- Avatar --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle p-1 bg-primary" width="110" height="110" style="object-fit:cover;">
                                @else
                                    <img src="{{ asset('/') }}superadmin/assets/images/avatars/avatar-2.png" alt="{{ $user->name }}" class="rounded-circle p-1 bg-primary" width="110">
                                @endif
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
                                    <p class="text-secondary mb-1">Vendor{{ $vendor ? ' · ' . $vendor->shop_name : '' }}</p>
                                    <p class="text-muted font-size-sm">{{ $user->email }}</p>
                                </div>
                            </div>

                            <hr class="my-4" />

                            <form action="{{ route('vendor.profiles.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <input type="hidden" name="phone" value="{{ $user->phone }}">

                                <label for="avatar" class="form-label">Change Avatar</label>
                                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*" required>
                                <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Update Photo</button>
                            </form>

                            @if ($vendor)
                                <hr class="my-4" />
                                <a href="{{ route('vendor.shops') }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bx bx-store-alt"></i> Manage My Shop
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Info + Password --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('vendor.profiles.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Full Name</h6></div>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Email</h6></div>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Phone</h6></div>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Change Password</h6>
                            <form action="{{ route('vendor.profiles.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Current Password</h6></div>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current password" required>
                                            <span class="input-group-text toggle-password" style="cursor:pointer;"><i class='bx bx-hide'></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">New Password</h6></div>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters" required>
                                            <span class="input-group-text toggle-password" style="cursor:pointer;"><i class='bx bx-hide'></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3"><h6 class="mb-0">Confirm Password</h6></div>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password" required>
                                            <span class="input-group-text toggle-password" style="cursor:pointer;"><i class='bx bx-hide'></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary px-4">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bx-hide', 'bx-show');
                } else {
                    input.type = 'password';
                    icon.classList.replace('bx-show', 'bx-hide');
                }
            });
        });
    </script>
@endpush