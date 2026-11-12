@php
    $currency = $siteSettings->currency_symbol ?? '৳';
    $fmt = fn ($d) => $d ? \Carbon\Carbon::parse($d)->timezone('Asia/Dhaka')->format('Y-m-d\TH:i') : '';
@endphp

<div class="row">
    {{-- LEFT --}}
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Coupon Information</h6>

                <div class="mb-3">
                    <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="code" id="couponCode"
                               class="form-control text-uppercase @error('code') is-invalid @enderror"
                               value="{{ old('code', $coupon->code) }}" placeholder="EID2026" maxlength="50" required>
                        <button type="button" class="btn btn-outline-secondary" id="generateCode">
                            <i class="bx bx-refresh"></i> Generate
                        </button>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">শুধু অক্ষর, সংখ্যা, - এবং _ ব্যবহার করুন। Customer এই code checkout এ দেবে।</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select name="type" id="couponType" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed Amount ({{ $currency }})</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0.01" name="value"
                                   class="form-control @error('value') is-invalid @enderror"
                                   value="{{ old('value', $coupon->value) }}" required>
                            <span class="input-group-text" id="valueSuffix">%</span>
                            @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimum Order Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $currency }}</span>
                            <input type="number" step="0.01" min="0" name="min_order_amount"
                                   class="form-control @error('min_order_amount') is-invalid @enderror"
                                   value="{{ old('min_order_amount', $coupon->min_order_amount) }}" placeholder="0">
                            @error('min_order_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">0 বা ফাঁকা মানে কোনো minimum নেই।</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Usage Limit</label>
                        <input type="number" min="1" name="usage_limit"
                               class="form-control @error('usage_limit') is-invalid @enderror"
                               value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="Unlimited">
                        @error('usage_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">ফাঁকা রাখলে unlimited।</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Validity Period</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Starts At</label>
                        <input type="datetime-local" name="starts_at"
                               class="form-control @error('starts_at') is-invalid @enderror"
                               value="{{ old('starts_at', $fmt($coupon->starts_at)) }}">
                        @error('starts_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expires At</label>
                        <input type="datetime-local" name="expires_at"
                               class="form-control @error('expires_at') is-invalid @enderror"
                               value="{{ old('expires_at', $fmt($coupon->expires_at)) }}">
                        @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <small class="text-muted">দুটোই ফাঁকা রাখলে coupon সবসময় valid থাকবে।</small>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Status</h6>
                <input type="hidden" name="status" value="0">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1"
                        {{ old('status', $coupon->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <small class="text-muted">বন্ধ থাকলে customer এই coupon ব্যবহার করতে পারবে না।</small>
            </div>
        </div>

        <div class="card mb-3 border-primary">
            <div class="card-body p-4">
                <h6 class="mb-3">Live Preview</h6>
                <div class="text-center p-3 rounded" style="border:2px dashed #0d6efd;">
                    <div class="text-muted small">Coupon Code</div>
                    <div class="fs-4 fw-bold text-primary" id="previewCode">{{ old('code', $coupon->code) ?: 'YOURCODE' }}</div>
                    <div class="fs-5 mt-1"><span id="previewValue">0</span> OFF</div>
                    <div class="small text-muted mt-1" id="previewMin"></div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> {{ $coupon->exists ? 'Update Coupon' : 'Create Coupon' }}
            </button>
            <a href="{{ route('superadmin.coupons.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>

<script>
    (function () {
        const currency = @json($currency);
        const code = document.getElementById('couponCode');
        const type = document.getElementById('couponType');
        const value = document.querySelector('[name="value"]');
        const minAmt = document.querySelector('[name="min_order_amount"]');
        const suffix = document.getElementById('valueSuffix');

        function refresh() {
            const isPct = type.value === 'percentage';
            suffix.textContent = isPct ? '%' : currency;
            value.max = isPct ? 100 : '';

            const v = value.value || 0;
            document.getElementById('previewValue').textContent = isPct ? v + '%' : currency + v;
            document.getElementById('previewCode').textContent = (code.value || 'YOURCODE').toUpperCase();

            const m = parseFloat(minAmt.value || 0);
            document.getElementById('previewMin').textContent = m > 0 ? 'Min. order ' + currency + m : '';
        }

        document.getElementById('generateCode').addEventListener('click', function () {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let out = '';
            for (let i = 0; i < 8; i++) out += chars[Math.floor(Math.random() * chars.length)];
            code.value = out;
            refresh();
        });

        [code, type, value, minAmt].forEach(el => el.addEventListener('input', refresh));
        type.addEventListener('change', refresh);
        refresh();
    })();
</script>
