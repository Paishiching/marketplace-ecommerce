<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Zone Information</h6>

                <div class="mb-3">
                    <label class="form-label">Zone Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $zone->name) }}" placeholder="Dhaka Metro, Chattogram, Outside Dhaka..." maxlength="100" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Zone এর নাম (যেমনঃ Dhaka Metro, Sylhet Division)।</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Regions</label>
                    <textarea name="regions" rows="3"
                              class="form-control @error('regions') is-invalid @enderror"
                              placeholder="Dhaka, Gazipur, Narayanganj">{{ old('regions', is_array($zone->regions ?? null) ? implode(', ', $zone->regions) : '') }}</textarea>
                    @error('regions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">District/Division গুলো কমা (,) দিয়ে আলাদা করে লিখুন।</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Status</h6>
                <input type="hidden" name="status" value="0">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1"
                        {{ old('status', $zone->status ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <small class="text-muted">বন্ধ থাকলে এই zone নতুন rate তৈরির সময় দেখানো হবে না।</small>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> {{ $zone->exists ? 'Update Zone' : 'Add Zone' }}
            </button>
            <a href="{{ route('superadmin.shipping-zones.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>
