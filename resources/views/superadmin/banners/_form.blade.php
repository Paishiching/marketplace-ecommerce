@php
    $selectedPosition = old('position', $banner->position ?? request('position'));
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Banner Information</h6>

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $banner->title) }}" placeholder="Samsung TV Hot Deals, Free Delivery..." maxlength="150" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image @if (!$banner->exists)<span class="text-danger">*</span>@endif</label>
                    <input type="file" name="image" id="bannerImage" accept=".jpg,.jpeg,.png,.webp,.gif,image/*"
                           class="form-control @error('image') is-invalid @enderror" {{ $banner->exists ? '' : 'required' }}>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">JPG, PNG, WEBP বা GIF (animated GIF চলবে), সর্বোচ্চ 4MB। Position অনুযায়ী recommended size ব্যবহার করুন।</small>

                    <div class="mt-3">
                        <img id="bannerPreview"
                             src="{{ $banner->exists && $banner->image ? asset('uploads/banners/' . $banner->image) : '' }}"
                             alt="Preview" class="img-fluid rounded border {{ $banner->exists && $banner->image ? '' : 'd-none' }}"
                             style="max-height:200px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link (URL)</label>
                    <input type="url" name="link"
                           class="form-control @error('link') is-invalid @enderror"
                           value="{{ old('link', $banner->link) }}" placeholder="https://example.com/category/tv" maxlength="255">
                    @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Banner এ click করলে এই page এ যাবে (optional)। খালি রাখলে banner click করা যাবে না।</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Position <span class="text-danger">*</span></h6>
                <select name="position" id="bannerPosition" class="form-select @error('position') is-invalid @enderror" required>
                    <option value="">-- Select position --</option>
                    @foreach (\App\Models\Banner::positionGroups() as $group => $items)
                        <optgroup label="{{ $group }}">
                            @foreach ($items as $key => $item)
                                <option value="{{ $key }}" {{ $selectedPosition === $key ? 'selected' : '' }}>{{ $item['label'] }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror

                <div id="positionInfo" class="alert alert-info small mt-3 mb-0 d-none">
                    <div><strong>Recommended size:</strong> <span id="infoSize"></span></div>
                    <div class="mt-1" id="infoNote"></div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Sort Order</h6>
                <input type="number" name="sort_order" min="0" max="9999"
                       class="form-control @error('sort_order') is-invalid @enderror"
                       value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">ছোট number আগে দেখাবে। Main Slider এ serial ঠিক করতে কাজে লাগে।</small>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Status</h6>
                <input type="hidden" name="status" value="0">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1"
                        {{ old('status', $banner->status ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <small class="text-muted">বন্ধ থাকলে এই banner website এ দেখানো হবে না।</small>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> {{ $banner->exists ? 'Update Banner' : 'Add Banner' }}
            </button>
            <a href="{{ route('superadmin.banners.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>

<script>
    (function () {
        const positions = @json($positions);
        const select    = document.getElementById('bannerPosition');
        const box       = document.getElementById('positionInfo');

        function showInfo() {
            const p = positions[select.value];
            if (!p) { box.classList.add('d-none'); return; }
            document.getElementById('infoSize').textContent = p.size;
            document.getElementById('infoNote').textContent = p.note;
            box.classList.remove('d-none');
        }
        select.addEventListener('change', showInfo);
        showInfo();

        document.getElementById('bannerImage').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('bannerPreview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        });
    })();
</script>