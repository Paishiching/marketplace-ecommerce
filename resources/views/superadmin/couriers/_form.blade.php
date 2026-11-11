@php
    $drivers = config('couriers.drivers');
    $current = old('driver', $courier->driver ?: 'manual');
    $saved   = $courier->exists ? ($courier->credentials ?? []) : [];
@endphp

<div class="row">
    <div class="col-lg-8">
        @error('credentials')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Courier Information</h6>

                <div class="mb-3">
                    <label class="form-label">Courier Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $courier->name) }}" placeholder="Pathao, Steadfast, Sundarban..." maxlength="100" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Integration Type <span class="text-danger">*</span></label>
                    <select name="driver" id="driver" class="form-select @error('driver') is-invalid @enderror" required>
                        @foreach ($drivers as $key => $cfg)
                            <option value="{{ $key }}" @selected($current === $key)>{{ $cfg['label'] }}</option>
                        @endforeach
                    </select>
                    @error('driver')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">API nei emon courier (Sundarban etc.) hole <b>Manual</b> select korun.</small>
                </div>

                @foreach ($drivers as $key => $cfg)
                    @if ($cfg['fields'])
                        <div class="driver-fields border rounded p-3 mb-3" data-driver="{{ $key }}" style="display:none;">
                            <div class="fw-bold mb-2">{{ $cfg['label'] }} credentials</div>
                            @foreach ($cfg['fields'] as $field => $label)
                                <div class="mb-2">
                                    <label class="form-label">{{ $label }}</label>
                                    <input type="password" autocomplete="new-password"
                                           name="credentials[{{ $field }}]" class="form-control"
                                           placeholder="{{ ($courier->driver === $key && ! empty($saved[$field])) ? 'Saved. Leave blank to keep current.' : 'Enter ' . $label }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach

                <div class="mb-3">
                    <label class="form-label">Tracking URL</label>
                    <input type="url" name="tracking_url"
                           class="form-control @error('tracking_url') is-invalid @enderror"
                           value="{{ old('tracking_url', $courier->tracking_url) }}"
                           placeholder="https://track.example.com/{tracking_number}">
                    @error('tracking_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted"><code>{tracking_number}</code> placeholder diye dile order page e clickable tracking link hoy.</small>
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
                        {{ old('status', $courier->exists ? $courier->status : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <small class="text-muted">Bondho thakle order e ei courier select kora jabe na.</small>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> {{ $courier->exists ? 'Update Courier' : 'Add Courier' }}
            </button>
            <a href="{{ route('superadmin.couriers.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const select = document.getElementById('driver');

            function toggle() {
                document.querySelectorAll('.driver-fields').forEach(function (box) {
                    const active = box.dataset.driver === select.value;
                    box.style.display = active ? '' : 'none';
                    box.querySelectorAll('input').forEach(i => i.disabled = !active);
                });
            }

            select.addEventListener('change', toggle);
            toggle();
        })();
    </script>
@endpush