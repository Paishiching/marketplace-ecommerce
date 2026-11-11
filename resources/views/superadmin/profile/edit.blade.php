@extends('layouts.superadmin.app')

@section('title','My Profile')

@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

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

            <div class="container-fluid">
                <div class="main-body">
                    <div class="row">
                        <!-- Avatar Card -->
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
                                            <p class="text-secondary mb-1">{{ $user->getRoleNames()->first() ?? 'Super Admin' }}</p>
                                            <p class="text-muted font-size-sm">{{ $user->email }}</p>
                                        </div>
                                    </div>

                                    <hr class="my-4" />

                                    <form action="{{ route('superadmin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="name" value="{{ $user->name }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <input type="hidden" name="phone" value="{{ $user->phone }}">

                                        <label for="avatar" class="form-label">Change Avatar</label>
                                        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Update Photo</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Info + Password -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('superadmin.profile.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" />
                                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" />
                                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Phone</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" />
                                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                    <form action="{{ route('superadmin.profile.password.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Current Password</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password" name="current_password" class="form-control pw-field @error('current_password') is-invalid @enderror" placeholder="Enter current password">
                                                    <span class="input-group-text toggle-password" style="cursor:pointer;"><i class='bx bx-hide'></i></span>
                                                </div>
                                                @error('current_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">New Password</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password" name="password" class="form-control pw-field @error('password') is-invalid @enderror" placeholder="Minimum 8 characters">
                                                    <span class="input-group-text toggle-password" style="cursor:pointer;"><i class='bx bx-hide'></i></span>
                                                </div>
                                                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Confirm Password</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation" class="form-control pw-field" placeholder="Re-enter new password">
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
        </div>
    </div>
    <!--end page wrapper -->
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bx-hide');
                    icon.classList.add('bx-show');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bx-show');
                    icon.classList.add('bx-hide');
                }
            });
        });
    </script>
@endpush
