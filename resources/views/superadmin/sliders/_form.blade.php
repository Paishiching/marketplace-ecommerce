<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Slider Information</h6>

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $slider->title) }}" placeholder="Eid Mega Sale, New Arrivals..." maxlength="150" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image @if (!$slider->exists)<span class="text-danger">*</span>@endif</label>
                    <input type="file" name="image" id="sliderImage" accept="image/*"
                           class="form-control @error('image') is-invalid @enderror" {{ $slider->exists ? '' : 'required' }}>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Recommended size: 1920×600 px। JPG, PNG বা WEBP, সর্বোচ্চ 4MB।</small>

                    <div class="mt-3">
                        <img id="sliderPreview"
                             src="{{ $slider->exists && $slider->image ? asset('uploads/sliders/' . $slider->image) : '' }}"
                             alt="Preview" class="img-fluid rounded border {{ $slider->exists && $slider->image ? '' : 'd-none' }}"
                             style="max-height:200px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link (URL)</label>
                    <input type="url" name="link"
                           class="form-control @error('link') is-invalid @enderror"
                           value="{{ old('link', $slider->link) }}" placeholder="https://example.com/campaign/eid-sale" maxlength="255">
                    @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Slider এ click করলে যে page এ যাবে (optional)।</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Display Order</h6>
                <input type="number" name="sort_order" min="0"
                       class="form-control @error('sort_order') is-invalid @enderror"
                       value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">ছোট number আগে দেখাবে (0, 1, 2...)।</small>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body p-4">
                <h6 class="mb-3">Status</h6>
                <input type="hidden" name="status" value="0">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1"
                        {{ old('status', $slider->status ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <small class="text-muted">বন্ধ থাকলে এই slider website এ দেখানো হবে না।</small>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> {{ $slider->exists ? 'Update Slider' : 'Add Slider' }}
            </button>
            <a href="{{ route('superadmin.sliders.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>

<script>
    document.getElementById('sliderImage').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('sliderPreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        }
    });
</script>
