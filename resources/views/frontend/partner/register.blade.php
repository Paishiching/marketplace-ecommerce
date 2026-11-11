@extends('layouts.frontend.app')

@section('title', $cfg['title'])

@section('content')

    <style>
        .bv-section{padding:40px 0 70px;background:#f6f8fc;display:block}
        .bv-card{display:block;width:100%;background:#fff;border:1px solid #e9eef6;border-radius:18px;box-shadow:0 10px 30px rgba(16,42,90,.06);padding:34px;opacity:1;visibility:visible;transform:none}
        .bv-card h2{font-weight:800;color:#14213d;margin-bottom:6px;font-size:28px}
        .bv-card p.bv-sub{color:#64748b;margin-bottom:24px}
        .bv-card h5{font-weight:800;color:#14213d;margin:22px 0 12px;font-size:16px}
        .bv-card label{font-weight:600;color:#334155;margin-bottom:6px;display:block}
        .bv-card .form-control{width:100%}
        .bv-card .bv-btn,
        button.bv-btn{
            display:inline-flex !important;align-items:center;justify-content:center;
            min-width:200px;height:48px;padding:0 34px !important;border:0 !important;
            border-radius:50px !important;
            background:linear-gradient(135deg,#3a9bff,#146cda) !important;
            color:#fff !important;font-size:15px !important;font-weight:700 !important;
            cursor:pointer;box-shadow:0 8px 18px rgba(20,108,218,.35) !important;
            opacity:1 !important;visibility:visible !important;
        }
    </style>

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row"><div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('homes') }}">Home</a></li>
                            <li>{{ $cfg['title'] }}</li>
                        </ul>
                    </div>
                </div></div>
        </div>
    </div>

    <section class="bv-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="bv-card">
                        <h2>{{ $cfg['title'] }}</h2>
                        <p class="bv-sub">{{ $cfg['sub'] }}</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route($registrationRoute ?? ('become-' . $type . '.store')) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf

                            @guest
                                <h5>Account Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name">Full Name *</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Phone *</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email">Email *</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password">Password *</label>
                                        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation">Confirm Password *</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password" required>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">Apni <strong>{{ auth()->user()->email }}</strong> account diye apply korchen.</div>
                            @endguest

                            @if ($type === 'vendor')
                                <h5>Shop Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="shop_name">Shop Name *</label>
                                        <input type="text" name="shop_name" id="shop_name" class="form-control" value="{{ old('shop_name') }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description">About Your Shop</label>
                                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="logo">Shop Logo</label>
                                        <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            @elseif ($type === 'supplier')
                                <h5>Company Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="company_name">Company Name *</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name') }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description">About Your Company</label>
                                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="logo">Company Logo</label>
                                        <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            @elseif (in_array($type, ['reseller', 'dropshipping', 'wholesale'], true))
                                <h5>Business Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="business_name">Business Name *</label>
                                        <input type="text" name="business_name" id="business_name" class="form-control" value="{{ old('business_name') }}" required>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted mt-3 mb-0">Your referral code will be created after your application is approved.</p>
                            @endif

                            <div class="mt-4">
                                <button type="submit" class="bv-btn">Submit Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
