@php
    $p = $product ?? null;

    $variantRows = old('variants', $p
        ? $p->productVariants->map(fn ($v) => [
            'id' => $v->id, 'unit_type' => $v->unit_type, 'unit_value' => $v->unit_value,
            'price' => $v->price, 'stock_quantity' => $v->stock_quantity, 'sku' => $v->sku,
        ])->all()
        : [[]]);
    if (empty($variantRows)) { $variantRows = [[]]; }

    $hasVariantsOn = old('has_variants', $p ? ($p->productVariants->count() > 0 ? '1' : '0') : '1') == '1';

    $selectedColors = old('colors', $p ? $p->colorValues->pluck('id')->toArray() : []);
    $selectedSizes  = old('sizes', $p ? $p->sizeValues->pluck('id')->toArray() : []);
    $subList        = $subCategories ?? collect();
@endphp

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <strong><i class="bx bx-error-circle"></i> {{ session('error') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong><i class="bx bx-error-circle"></i> Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">

    {{-- ============ LEFT ============ --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title d-flex align-items-center gap-2">
                    <i class="bx bx-info-circle text-primary"></i> Basic Information
                </h5>
                <hr/>

                <div class="mb-3">
                    <label for="name" class="form-label">Product Title <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="e.g. Premium Basmati Rice" value="{{ old('name', $p->name ?? '') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="sku" class="form-label">Product SKU</label>
                    <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror"
                           placeholder="e.g. PROD-0001" value="{{ old('sku', $p->sku ?? '') }}">
                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea name="short_description" id="short_description" rows="2" class="form-control"
                              placeholder="A brief summary shown on listing / card pages">{{ old('short_description', $p->short_description ?? '') }}</textarea>
                </div>

                <div class="mb-0">
                    <label for="mytextarea" class="form-label">Long Description</label>
                    <textarea name="description" id="mytextarea" class="form-control">{{ old('description', $p->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title d-flex align-items-center gap-2">
                    <i class="bx bx-image text-primary"></i> Product Images
                </h5>
                <hr/>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail Image @unless($p)<span class="text-danger">*</span>@endunless</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                           accept="image/*" {{ $p ? '' : 'required' }}>
                    <small class="text-muted">Recommended 800x800px, max 2MB{{ $p ? '. Khali rakhle ager thumbnail thakbe' : '' }}</small>
                    @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <div id="thumbnailPreview" class="mt-2">
                        @if ($p && $p->thumbnail)
                            <img src="{{ asset('storage/' . $p->thumbnail) }}" alt="" style="max-height:120px;border-radius:6px;">
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gallery" class="form-label">{{ $p ? 'Add More Gallery Images' : 'Gallery Images' }}</label>
                    <input type="file" name="gallery_images[]" id="gallery" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Multiple select kora jabe, max 2MB each</small>
                </div>

                @if ($p && $p->productImages->count())
                    <label class="form-label fw-semibold">Current Gallery Images</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($p->productImages as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" style="width:90px;height:90px;object-fit:cover;border-radius:6px;" alt="">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm" id="attributeCard">
            <div class="card-body p-4">
                <h5 class="card-title d-flex align-items-center gap-2">
                    <i class="bx bx-palette text-primary"></i> Color & Size
                </h5>
                <p class="text-muted small mb-3">Optional.</p>
                <hr/>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Colors</label>
                        <div class="border rounded p-3 d-flex flex-wrap gap-3 bg-light">
                            @forelse($colors ?? [] as $color)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="colors[]" value="{{ $color->id }}" id="color_{{ $color->id }}"
                                        {{ in_array($color->id, $selectedColors) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="color_{{ $color->id }}">{{ $color->value }}</label>
                                </div>
                            @empty
                                <span class="text-muted small">No colors added yet</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Sizes</label>
                        <div class="border rounded p-3 d-flex flex-wrap gap-3 bg-light">
                            @forelse($sizes ?? [] as $size)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}"
                                        {{ in_array($size->id, $selectedSizes) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="size_{{ $size->id }}">{{ $size->value }}</label>
                                </div>
                            @empty
                                <span class="text-muted small">No sizes added yet</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" id="variantCard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h5 class="card-title d-flex align-items-center gap-2 mb-0">
                        <i class="bx bx-package text-primary"></i> Unit Variants
                    </h5>
                    <button type="button" id="addVariantBtn" class="btn btn-primary btn-sm" style="{{ $hasVariantsOn ? '' : 'display:none;' }}">
                        <i class="bx bx-plus"></i> Add Variant
                    </button>
                </div>
                <p class="text-muted small mb-3">Selling unit, jemon 1kg, 500gram, 1 piece. Protitar alada price ar stock.</p>
                <hr/>

                <input type="hidden" name="has_variants" id="has_variants_hidden" value="{{ $hasVariantsOn ? '1' : '0' }}">

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="hasVariants" {{ $hasVariantsOn ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="hasVariants">
                        This product has unit variants (1kg, 500gram, 1 piece, etc.)
                    </label>
                </div>

                <div id="simpleStockSection" class="row g-3 mb-3" style="display:{{ $hasVariantsOn ? 'none' : '' }};">
                    <div class="col-md-4">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" min="0" name="simple_stock_quantity" class="form-control" placeholder="e.g. 50"
                               value="{{ old('simple_stock_quantity', $p && $p->productVariants->count() === 1 ? $p->productVariants->first()->stock_quantity : '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">SKU (optional)</label>
                        <input type="text" name="simple_sku" class="form-control" placeholder="Optional"
                               value="{{ old('simple_sku', $p && $p->productVariants->count() === 1 ? $p->productVariants->first()->sku : '') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <small class="text-muted">Price Pricing section theke newa hobe.</small>
                    </div>
                </div>

                <div id="unitVariantSection" style="display:{{ $hasVariantsOn ? '' : 'none' }};">
                    <div class="table-responsive">
                        <table class="table align-middle" id="variantTable">
                            <thead class="table-light">
                            <tr>
                                <th style="width:20%">Unit</th>
                                <th style="width:15%">Value</th>
                                <th style="width:18%">Price</th>
                                <th style="width:15%">Stock</th>
                                <th style="width:22%">SKU (optional)</th>
                                <th style="width:10%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody id="variantWrapper">
                            @foreach ($variantRows as $i => $v)
                                <tr class="variant-row">
                                    <td>
                                        <select name="variants[{{ $i }}][unit_type]" class="form-select form-select-sm">
                                            @foreach (['kg' => 'KG', 'gram' => 'Gram', 'piece' => 'Piece', 'litre' => 'Litre', 'ml' => 'ML', 'dozen' => 'Dozen', 'box' => 'Box'] as $val => $label)
                                                <option value="{{ $val }}" {{ ($v['unit_type'] ?? 'kg') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" step="0.01" min="0" name="variants[{{ $i }}][unit_value]" class="form-control form-control-sm" placeholder="e.g. 1" value="{{ $v['unit_value'] ?? '' }}"></td>
                                    <td><input type="number" step="0.01" min="0" name="variants[{{ $i }}][price]" class="form-control form-control-sm" placeholder="Price" value="{{ $v['price'] ?? '' }}"></td>
                                    <td><input type="number" min="0" name="variants[{{ $i }}][stock_quantity]" class="form-control form-control-sm" placeholder="Stock" value="{{ $v['stock_quantity'] ?? '' }}"></td>
                                    <td>
                                        <input type="text" name="variants[{{ $i }}][sku]" class="form-control form-control-sm" placeholder="Optional" value="{{ $v['sku'] ?? '' }}">
                                        @if (! empty($v['id']))
                                            <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $v['id'] }}">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-variant" style="{{ $loop->first && ! $p ? 'display:none;' : '' }}" title="Remove">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ RIGHT ============ --}}
    <div class="col-lg-4">
        <div class="sticky-sidebar">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title d-flex align-items-center gap-2">
                        <i class="bx bx-folder text-primary"></i> Organize
                    </h5>
                    <hr/>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $p->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sub_category_id" class="form-label">Sub Category</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-select">
                            @if ($p)
                                <option value="">Select Sub Category</option>
                                @foreach($subList as $sub)
                                    <option value="{{ $sub->id }}" {{ old('sub_category_id', $p->sub_category_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                @endforeach
                            @else
                                <option value="">Select Category First</option>
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Brand</label>
                        <select name="brand_id" id="brand_id" class="form-select">
                            <option value="">Select Brand</option>
                            @foreach($brands ?? [] as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $p->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-0">
                        <label for="tags" class="form-label">Product Tags</label>
                        <input type="text" name="tags" id="tags" class="form-control" placeholder="Comma separated tags" value="{{ old('tags', $p->tags ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title d-flex align-items-center gap-2">
                        <i class="bx bx-dollar-circle text-primary"></i> Pricing
                    </h5>
                    <hr/>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" min="0" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                                   placeholder="00.00" value="{{ old('price', $p->price ?? '') }}" required>
                        </div>
                        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount_percent" class="form-label">Discount %</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" max="100" id="discount_percent" class="form-control" placeholder="e.g. 10">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="discount_price" class="form-label">Discount Price</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" min="0" name="discount_price" id="discount_price" class="form-control @error('discount_price') is-invalid @enderror"
                                   placeholder="00.00" value="{{ old('discount_price', $p->discount_price ?? '') }}">
                        </div>
                        @error('discount_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label for="cost_price" class="form-label">Cost Per Price</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" min="0" name="cost_price" id="cost_price" class="form-control"
                                   placeholder="00.00" value="{{ old('cost_price', $p->cost_price ?? '') }}">
                        </div>
                        <small class="text-muted">Customer ke dekhano hoy na</small>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title d-flex align-items-center gap-2">
                        <i class="bx bx-shield-quarter text-primary"></i> Approval
                    </h5>
                    <hr/>
                    <p class="mb-0 small text-muted">
                        Save korle product <strong>Pending</strong> thakbe. Admin approve korle website e live hobe.
                        Product edit korle abar approval lagbe.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fixed-action-bar">
    <a href="{{ route('vendor.products.products.index') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bx bx-x"></i> Cancel
    </a>
    <button type="submit" class="btn btn-primary btn-lg">
        <i class="bx bx-save"></i> {{ $p ? 'Update Product' : 'Save Product' }}
    </button>
</div>

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <style>
        .card-title i { font-size: 1.1rem; }
        #variantTable td { vertical-align: middle; }
        @media (min-width: 992px) {
            .sticky-sidebar { position: sticky; top: 90px; max-height: calc(100vh - 110px); overflow-y: auto; padding-right: 4px; }
        }
        .fixed-action-bar {
            position: fixed; bottom: 0; right: 0; left: 250px; z-index: 1000;
            display: flex; justify-content: center; gap: 12px; padding: 12px 24px;
            background: #fff; border-top: 1px solid #e5e5e5; box-shadow: 0 -2px 8px rgba(0,0,0,.06);
        }
        .page-content { padding-bottom: 90px; }
        @media (max-width: 1024px) { .fixed-action-bar { left: 0; } }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#mytextarea').summernote({
                placeholder: 'Write product description...',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });

            $('#category_id, #sub_category_id, #brand_id').select2({ width: '100%' });

            // ---------- Category -> SubCategory ----------
            const subUrl = "{{ route('vendor.categories.subcategories', ':id') }}";
            const $sub   = $('#sub_category_id');

            function loadSubCategories(categoryId, selectedId) {
                if (!categoryId) {
                    $sub.html('<option value="">Select Category First</option>').trigger('change.select2');
                    return;
                }
                $sub.html('<option value="">Loading...</option>').trigger('change.select2');

                fetch(subUrl.replace(':id', categoryId), { headers: { 'Accept': 'application/json' } })
                    .then(res => { if (!res.ok) throw new Error(res.status); return res.json(); })
                    .then(data => {
                        if (!data.length) {
                            $sub.html('<option value="">No sub category found</option>').trigger('change.select2');
                            return;
                        }
                        $sub.html('<option value="">Select Sub Category</option>');
                        data.forEach(s => $sub.append(new Option(s.name, s.id, false, selectedId && String(selectedId) === String(s.id))));
                        $sub.trigger('change.select2');
                    })
                    .catch(() => $sub.html('<option value="">Failed to load</option>').trigger('change.select2'));
            }

            $('#category_id').on('change', function () { loadSubCategories($(this).val(), null); });

            @if(! $p && old('category_id'))
            loadSubCategories("{{ old('category_id') }}", "{{ old('sub_category_id') }}");
            @endif

            // ---------- Unit variants toggle ----------
            document.getElementById('hasVariants').addEventListener('change', function () {
                document.getElementById('has_variants_hidden').value = this.checked ? '1' : '0';
                document.getElementById('unitVariantSection').style.display = this.checked ? '' : 'none';
                document.getElementById('addVariantBtn').style.display      = this.checked ? '' : 'none';
                document.getElementById('simpleStockSection').style.display = this.checked ? 'none' : '';
            });

            // ---------- Add / remove variant rows ----------
            let variantIndex = {{ count($variantRows) }};

            function bindRemove(btn) {
                btn.addEventListener('click', function () { this.closest('.variant-row').remove(); });
            }
            document.querySelectorAll('.remove-variant').forEach(bindRemove);

            document.getElementById('addVariantBtn').addEventListener('click', function () {
                const newRow = document.querySelector('.variant-row').cloneNode(true);

                newRow.querySelectorAll('input').forEach(input => {
                    if (input.type === 'hidden') { input.remove(); return; }
                    input.value = '';
                    input.name = input.name.replace(/\[\d+\]/, '[' + variantIndex + ']');
                });
                newRow.querySelectorAll('select').forEach(select => {
                    select.name = select.name.replace(/\[\d+\]/, '[' + variantIndex + ']');
                    select.selectedIndex = 0;
                });

                const removeBtn = newRow.querySelector('.remove-variant');
                removeBtn.style.display = 'inline-block';
                bindRemove(removeBtn);

                document.getElementById('variantWrapper').appendChild(newRow);
                variantIndex++;
            });

            // ---------- Thumbnail preview ----------
            document.getElementById('thumbnail').addEventListener('change', function (e) {
                const preview = document.getElementById('thumbnailPreview');
                preview.innerHTML = '';
                const file = e.target.files[0];
                if (file) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxHeight = '120px';
                    img.style.borderRadius = '6px';
                    preview.appendChild(img);
                }
            });

            // ---------- Discount price <-> percent ----------
            const priceInput    = document.getElementById('price');
            const percentInput  = document.getElementById('discount_percent');
            const discountInput = document.getElementById('discount_price');

            function calculateDiscountPrice() {
                const price = parseFloat(priceInput.value) || 0;
                const pct   = parseFloat(percentInput.value) || 0;
                if (price > 0 && pct > 0) discountInput.value = (price - price * pct / 100).toFixed(2);
            }
            function calculatePercentFromPrice() {
                const price = parseFloat(priceInput.value) || 0;
                const disc  = parseFloat(discountInput.value) || 0;
                if (price > 0 && disc > 0 && disc < price) percentInput.value = (((price - disc) / price) * 100).toFixed(2);
            }
            priceInput.addEventListener('input', calculateDiscountPrice);
            percentInput.addEventListener('input', calculateDiscountPrice);
            discountInput.addEventListener('input', calculatePercentFromPrice);
            if (priceInput.value && discountInput.value) calculatePercentFromPrice();
        });
    </script>
@endpush
