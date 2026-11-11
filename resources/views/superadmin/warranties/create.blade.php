
@extends('layouts.superadmin.app')

@section('title','Add Warranty')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Warranty</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.warranties.index') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Warranty</li>
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

            <form action="{{ route('superadmin.warranties.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Product Information</h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="serial_number" class="form-label">Serial Number (S/N) <span class="text-danger">*</span></label>
                                    <input type="text" name="serial_number" id="serial_number" class="form-control text-uppercase @error('serial_number') is-invalid @enderror"
                                           placeholder="Enter product serial number" value="{{ old('serial_number') }}" maxlength="60" required>
                                    @error('serial_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror"
                                           placeholder="e.g. Haier 1.5 Ton Inverter AC" value="{{ old('product_name') }}">
                                    @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <h5 class="card-title mt-4">Customer Information</h5>
                                <hr/>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_name" class="form-label">Customer Name</label>
                                        <input type="text" name="customer_name" id="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                                               placeholder="Enter customer name" value="{{ old('customer_name') }}">
                                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="01XXXXXXXXX" value="{{ old('phone') }}" maxlength="30" required>
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="text-muted">Customer ei number diye warranty check korbe</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title">Warranty Period</h5>
                                <hr/>

                                <div class="mb-3">
                                    <label for="purchase_date" class="form-label">Date of Purchase <span class="text-danger">*</span></label>
                                    <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror"
                                           value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                    @error('purchase_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="warranty_months" class="form-label">Warranty (months) <span class="text-danger">*</span></label>
                                    <input type="number" name="warranty_months" id="warranty_months" class="form-control @error('warranty_months') is-invalid @enderror"
                                           value="{{ old('warranty_months', 12) }}" min="1" max="240" required>
                                    @error('warranty_months') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="alert alert-light border mb-0 py-2" id="expPreview" style="font-size:13px;"></div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('superadmin.warranties.index') }}" class="btn btn-outline-secondary btn-lg w-50">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-lg w-50">Save Warranty</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var d = document.getElementById('purchase_date');
            var m = document.getElementById('warranty_months');
            var box = document.getElementById('expPreview');

            function show() {
                if (!d.value || !m.value) { box.textContent = ''; return; }
                var dt = new Date(d.value + 'T00:00:00');
                dt.setMonth(dt.getMonth() + parseInt(m.value, 10));
                box.innerHTML = 'Warranty expires at: <strong>' +
                    dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + '</strong>';
            }
            d.addEventListener('input', show);
            m.addEventListener('input', show);
            show();
        })();
    </script>
@endpush