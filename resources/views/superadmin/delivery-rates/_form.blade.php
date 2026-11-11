<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Rate Information</h6>

                <div class="mb-3">
                    <label class="form-label">Shipping Zone <span class="text-danger">*</span></label>
                    <select name="shipping_zone_id" class="form-select @error('shipping_zone_id') is-invalid @enderror" required>
                        <option value="">-- Select Zone --</option>
                        @foreach ($zones as $z)
                            <option value="{{ $z->id }}" {{ (string) old('shipping_zone_id', $rate->shipping_zone_id ?? '') === (string) $z->id ? 'selected' : '' }}>
                                {{ $z->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('shipping_zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Rate Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $rate->name) }}" placeholder="Standard, Express..." maxlength="100" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Rate এর নাম (যেমনঃ Standard, Express, Same Day)।</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rate (৳) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="rate"
                           class="form-control @error('rate') is-invalid @enderror"
                           value="{{ old('rate', $rate->rate) }}" placeholder="60.00" required>
                    @error('rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> {{ $rate->exists ? 'Update Rate' : 'Add Rate' }}
            </button>
            <a href="{{ route('superadmin.delivery-rates.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>
