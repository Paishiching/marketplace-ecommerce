@extends('layouts.superadmin.app')

@section('title','Edit Product')

@section('content')

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        </ol>
                    </nav>
                </div>
                <div class="ams-auto">
                    <a href="{{ route('superadmin.products.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back to Products
                    </a>
                </div>
            </div>
            <!--end breadcrumb-->
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

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong><i class="bx bx-error-circle"></i> {{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <form action="{{ route('superadmin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- LEFT COLUMN -->
                    <div class="col-lg-8">
                        <!-- Basic Info -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-info-circle text-primary"></i> Basic Information
                                </h5>
                                <p class="text-muted small mb-3">Enter the core details of the product.</p>
                                <hr/>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Title <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           id="name" placeholder="e.g. Premium Basmati Rice" value="{{ old('name', $product->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                               placeholder="auto-generated-from-title" value="{{ old('slug', $product->slug) }}">
                                        <small class="text-muted">Leave blank to auto-generate from title</small>
                                        @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sku" class="form-label">Product SKU</label>
                                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" id="sku"
                                               placeholder="e.g. PROD-0001" value="{{ old('sku', $product->sku) }}">
                                        @error('sku') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-3 mt-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" id="short_description"
                                              rows="2" placeholder="A brief summary shown on listing / card pages">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>

                                <div class="mb-0">
                                    <label for="description" class="form-label">Long Description</label>
                                    <textarea name="description" id="mytextarea" class="form-control">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /Basic Info -->

                        <!-- Product Images -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-image text-primary"></i> Product Images
                                </h5>
                                <p class="text-muted small mb-3">Upload a new thumbnail/gallery only if you want to replace or add images.</p>
                                <hr/>
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Leave blank to keep the current thumbnail</small>
                                    @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="thumbnailPreview" class="mt-2">
                                        @if ($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" style="max-height:120px;border-radius:6px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="image-uploadify" class="form-label">Add More Gallery Images</label>
                                    <input name="gallery_images[]" id="image-uploadify" type="file" accept="image/*" multiple class="form-control">
                                </div>

                                @if ($product->productImages->count())
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold">Current Gallery Images</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($product->productImages as $image)
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" style="width:90px;height:90px;object-fit:cover;border-radius:6px;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="text-muted d-block mt-1">Gallery image remove korte product show/details page e jaan (removal ekhane support kora hoyni)</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- /Product Images -->

                        <!-- Variants: Color & Size -->
                        <div class="card border-0 shadow-sm" id="attributeCard">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-palette text-primary"></i> Color & Size
                                </h5>
                                <p class="text-muted small mb-3">Select the colors and sizes available for this product (optional).</p>
                                <hr/>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Colors</label>
                                        <div class="border rounded p-3 d-flex flex-wrap gap-3 bg-light">
                                            @forelse($colors ?? [] as $color)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="colors[]" value="{{ $color->id }}" id="color_{{ $color->id }}"
                                                        {{ in_array($color->id, old('colors', $product->colorValues->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                                        {{ in_array($size->id, old('sizes', $product->sizeValues->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                        <!-- /Color & Size -->

                        <!-- Unit Variants -->
                        <div class="card border-0 shadow-sm" id="variantCard">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="card-title d-flex align-items-center gap-2 mb-0">
                                        <i class="bx bx-package text-primary"></i> Unit Variants
                                    </h5>
                                    <button type="button" id="addVariantBtn" class="btn btn-primary btn-sm">
                                        <i class="bx bx-plus"></i> Add Variant
                                    </button>
                                </div>
                                <p class="text-muted small mb-3">Define selling units for this product, e.g. 1kg, 500gram, 1 piece — each with its own price and stock.</p>
                                <hr/>

                                <input type="hidden" name="has_variants" id="has_variants_hidden" value="{{ $product->productVariants->count() > 0 ? '1' : '0' }}">

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="hasVariants" {{ $product->productVariants->count() > 0 ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="hasVariants">
                                        This product has unit variants (1kg, 500gram, 1 piece, etc.)
                                    </label>
                                </div>

                                <div id="simpleStockSection" class="row g-3 mb-3" style="display:{{ $product->productVariants->count() > 0 ? 'none' : '' }};">
                                    <div class="col-md-4">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" min="0" name="simple_stock_quantity" class="form-control" placeholder="e.g. 50"
                                               value="{{ old('simple_stock_quantity', $product->productVariants->count() === 1 ? $product->productVariants->first()->stock_quantity : '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">SKU (optional)</label>
                                        <input type="text" name="simple_sku" class="form-control" placeholder="Optional"
                                               value="{{ old('simple_sku', $product->productVariants->count() === 1 ? $product->productVariants->first()->sku : '') }}">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <small class="text-muted">Price is taken from the Pricing section above.</small>
                                    </div>
                                </div>

                                <div id="unitVariantSection" style="display:{{ $product->productVariants->count() > 0 ? '' : 'none' }};">
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
                                            @forelse($product->productVariants as $index => $variant)
                                                <tr class="variant-row">
                                                    <td>
                                                        <select name="variants[{{ $index }}][unit_type]" class="form-select form-select-sm">
                                                            @foreach (['kg' => 'KG', 'gram' => 'Gram', 'piece' => 'Piece', 'litre' => 'Litre', 'ml' => 'ML', 'dozen' => 'Dozen', 'box' => 'Box'] as $val => $label)
                                                                <option value="{{ $val }}" {{ $variant->unit_type == $val ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" min="0" name="variants[{{ $index }}][unit_value]" class="form-control form-control-sm" placeholder="e.g. 1" value="{{ $variant->unit_value }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" min="0" name="variants[{{ $index }}][price]" class="form-control form-control-sm" placeholder="Price" value="{{ $variant->price }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" name="variants[{{ $index }}][stock_quantity]" class="form-control form-control-sm" placeholder="Stock" value="{{ $variant->stock_quantity }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="variants[{{ $index }}][sku]" class="form-control form-control-sm" placeholder="Optional" value="{{ $variant->sku }}">
                                                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-variant" title="Remove">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="variant-row">
                                                    <td>
                                                        <select name="variants[0][unit_type]" class="form-select form-select-sm">
                                                            <option value="kg">KG</option>
                                                            <option value="gram">Gram</option>
                                                            <option value="piece">Piece</option>
                                                            <option value="litre">Litre</option>
                                                            <option value="ml">ML</option>
                                                            <option value="dozen">Dozen</option>
                                                            <option value="box">Box</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" min="0" name="variants[0][unit_value]" class="form-control form-control-sm" placeholder="e.g. 1">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" min="0" name="variants[0][price]" class="form-control form-control-sm" placeholder="Price">
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" name="variants[0][stock_quantity]" class="form-control form-control-sm" placeholder="Stock">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="variants[0][sku]" class="form-control form-control-sm" placeholder="Optional">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-variant" style="display:none;" title="Remove">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <small class="text-muted">At least one unit variant is recommended for accurate stock and pricing.</small>
                            </div>
                        </div>
                        <!-- /Unit Variants -->
                                                 <!-- Specifications -->
                        <div class="card border-0 shadow-sm" id="specCard">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="card-title d-flex align-items-center gap-2 mb-0">
                                        <i class="bx bx-list-ul text-primary"></i> Specifications
                                    </h5>
                                    <div class="d-flex gap-2">
                                        <button type="button" id="bulkSpecBtn" class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-paste"></i> Bulk Paste
                                        </button>
                                        <button type="button" id="addSpecBtn" class="btn btn-primary btn-sm">
                                            <i class="bx bx-plus"></i> Add Row
                                        </button>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3">Product-er technical details, jemon Brand, Color, Capacity. Website-e "Specifications" table hishebe dekhabe.</p>
                                <hr/>

                                <div id="bulkSpecBox" class="mb-3" style="display:none;">
                                    <label class="form-label">Bulk Paste <small class="text-muted">(protita line-e <code>Name: Value</code>)</small></label>
                                    <textarea id="bulkSpecText" class="form-control" rows="6" placeholder="Brand: Panasonic&#10;Color: Gray&#10;WM Capacity: 8 KG&#10;WM Type: Front Load"></textarea>
                                    <div class="mt-2">
                                        <button type="button" id="bulkSpecApply" class="btn btn-success btn-sm">Add These Rows</button>
                                        <button type="button" id="bulkSpecCancel" class="btn btn-outline-secondary btn-sm">Cancel</button>
                                    </div>
                                </div>

                                @php
                                    $dbSpecs = $product->productSpecifications
                                        ->map(fn ($s) => ['name' => $s->name, 'value' => $s->value])
                                        ->values()
                                        ->all();
                                    $oldSpecs = old('specifications', count($dbSpecs) ? $dbSpecs : [['name' => '', 'value' => '']]);
                                @endphp

                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th style="width:38%">Name</th>
                                            <th>Value</th>
                                            <th style="width:8%" class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="specWrapper">
                                        @foreach ($oldSpecs as $i => $s)
                                            <tr class="spec-row">
                                                <td><input type="text" name="specifications[{{ $i }}][name]" class="form-control form-control-sm" placeholder="e.g. Brand" value="{{ $s['name'] ?? '' }}"></td>
                                                <td><input type="text" name="specifications[{{ $i }}][value]" class="form-control form-control-sm" placeholder="e.g. Panasonic" value="{{ $s['value'] ?? '' }}"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-spec" title="Remove"><i class="bx bx-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /Specifications -->

                                                <!-- Sponsored / Offers -->
                        <div class="card border-0 shadow-sm" id="sponsoredCard">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex align-items-center gap-2">
                                    <i class="bx bx-gift text-primary"></i> Sponsored / Offers
                                </h5>
                                <p class="text-muted small mb-3">Product page-er "Sponsored" button-e click korle video ba offer image dekhabe. Duto-i optional.</p>
                                <hr/>

                                <div class="mb-3">
                                    <label for="sponsored_video_url" class="form-label">Video Link</label>
                                    <input type="url" name="sponsored_video_url" id="sponsored_video_url"
                                           class="form-control @error('sponsored_video_url') is-invalid @enderror"
                                           placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx"
                                           value="{{ old('sponsored_video_url', $product->sponsored_video_url) }}">
                                    <small class="text-muted">YouTube / Vimeo link, ba direct .mp4 link</small>
                                    @error('sponsored_video_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                @if ($product->offerImages->count())
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Current Offer Images</label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($product->offerImages as $oimg)
                                                <div class="offer-existing text-center">
                                                    <img src="{{ asset('storage/' . $oimg->image_path) }}" style="width:90px;height:90px;object-fit:cover;border-radius:6px;">
                                                    <div class="form-check mt-1 d-flex justify-content-center gap-1">
                                                        <input class="form-check-input offer-remove" type="checkbox" name="remove_offer_images[]" value="{{ $oimg->id }}" id="rm_offer_{{ $oimg->id }}">
                                                        <label class="form-check-label small text-danger" for="rm_offer_{{ $oimg->id }}">Remove</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-0">
                                    <label for="offer_images" class="form-label">Add Offer Images (total max 5)</label>
                                    <input type="file" name="offer_images[]" id="offer_images" accept="image/*" multiple
                                           class="form-control @error('offer_images') is-invalid @enderror">
                                    <small class="text-muted">Proti image max 2MB</small>
                                    @error('offer_images') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    @error('offer_images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <div id="offerPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Sponsored / Offers -->

                    </div>
                    <!-- /LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-4">
                        <div class="sticky-sidebar">

                            <!-- Organize -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title d-flex align-items-center gap-2">
                                        <i class="bx bx-folder text-primary"></i> Organize
                                    </h5>
                                    <hr/>

                                    <div class="mb-3">
                                        <label for="vendor_id" class="form-label">Vendor</label>
                                        <select name="vendor_id" id="vendor_id" class="form-select">
                                            <option value="">Select Vendor</option>
                                            @foreach($vendors ?? [] as $vendor)
                                                <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->shop_name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="sub_category_id" class="form-label">Sub Category</label>
                                        <select name="sub_category_id" id="sub_category_id" class="form-select">
                                            <option value="">Select Sub Category</option>
                                            @foreach($subCategories ?? [] as $sub)
                                                <option value="{{ $sub->id }}" {{ old('sub_category_id', $product->sub_category_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="brand_id" class="form-label">Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-select">
                                            <option value="">Select Brand</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_type" class="form-label">Product Type</label>
                                        <select name="product_type" id="product_type" class="form-select">
                                            <option value="vendor" {{ old('product_type', $product->product_type) == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                            <option value="supplier" {{ old('product_type', $product->product_type) == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                            <option value="affiliate" {{ old('product_type', $product->product_type) == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                                            <option value="dropshipping" {{ old('product_type', $product->product_type) == 'dropshipping' ? 'selected' : '' }}>Dropshipping</option>
                                            <option value="wholesale" {{ old('product_type', $product->product_type) == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                            <option value="reseller" {{ old('product_type', $product->product_type) == 'reseller' ? 'selected' : '' }}>Reseller</option>
                                        </select>
                                    </div>

                                    <div class="mb-0">
                                        <label for="tags" class="form-label">Product Tags</label>
                                        <input type="text" name="tags" class="form-control" id="tags"
                                               placeholder="Comma separated tags" value="{{ old('tags', $product->tags) }}">
                                        <small class="text-muted">e.g. organic, imported, bestseller</small>
                                    </div>
                                </div>
                            </div>
                            <!-- /Organize -->

                            <!-- Pricing -->
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
                                            <input type="number" step="0.01" min="0" name="price" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="00.00" value="{{ old('price', $product->price) }}" required>
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
                                            <input type="number" step="0.01" min="0" name="discount_price" id="discount_price" class="form-control @error('discount_price') is-invalid @enderror" placeholder="00.00" value="{{ old('discount_price', $product->discount_price) }}">
                                        </div>
                                        @error('discount_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label for="cost_price" class="form-label">Cost Per Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" step="0.01" min="0" name="cost_price" id="cost_price" class="form-control" placeholder="00.00" value="{{ old('cost_price', $product->cost_price) }}">
                                        </div>
                                        <small class="text-muted">For internal profit calculation, not shown to customers</small>
                                    </div>
                                </div>
                            </div>
                            <!-- /Pricing -->

                            <!-- Status -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title d-flex align-items-center gap-2">
                                        <i class="bx bx-toggle-left text-primary"></i> Status & Badges
                                    </h5>
                                    <hr/>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            @foreach (['draft' => 'Draft', 'pending' => 'Pending', 'published' => 'Published (Live)', 'rejected' => 'Rejected'] as $val => $label)
                                                <option value="{{ $val }}" @selected(old('status', $product->status) === $val)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_new" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_new">
                                            <span class="badge bg-success">New</span> New Arrival
                                        </label>
                                    </div>

                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            <span class="badge bg-warning text-dark">Featured</span> Show on Homepage
                                        </label>
                                    </div>

                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_hot" name="is_hot" value="1" {{ old('is_hot', $product->is_hot) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_hot">
                                            <span class="badge bg-danger">Hot</span> Trending / Best Seller
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /Status -->

                        </div><!-- /sticky-sidebar -->
                    </div>
                    <!-- /RIGHT COLUMN -->

                </div><!--end row-->

                <!-- Fixed bottom action bar -->
                <div class="fixed-action-bar">
                    <a href="{{ route('superadmin.products.index') . '#product-' . $product->id }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bx bx-x"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bx bx-save"></i> Update Product
                    </button>
                </div>

            </form>

        </div>
    </div>
    <!--end page wrapper -->

@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <style>
        .card-title i { font-size: 1.1rem; }
        #variantTable td { vertical-align: middle; }

        /* ডান column: স্ক্রল করলে উপরে আটকে থাকবে, লম্বা হলে নিজেই স্ক্রল হবে */
        @media (min-width: 992px) {
            .sticky-sidebar {
                position: sticky;
                top: 90px;
                max-height: calc(100vh - 110px);
                overflow-y: auto;
                padding-right: 4px;
            }
        }

        /* নিচে সবসময় আটকে থাকা Cancel / Update bar */
        .fixed-action-bar {
            position: fixed;
            bottom: 0;
            right: 0;
            left: 250px;
            z-index: 1000;
            display: flex;
            justify-content: center;
            gap: 12px;
            padding: 12px 24px;
            background: #fff;
            border-top: 1px solid #e5e5e5;
            box-shadow: 0 -2px 8px rgba(0,0,0,.06);
        }
        .page-content { padding-bottom: 90px; }

        @media (max-width: 1024px) {
            .fixed-action-bar { left: 0; }
        }
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
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function () {
            $('#vendor_id, #category_id, #sub_category_id, #brand_id, #product_type')
                .select2({ width: '100%' });
        });

        // Toggle: has unit variants or simple stock
        document.getElementById('hasVariants').addEventListener('change', function () {
            const unitSection   = document.getElementById('unitVariantSection');
            const addBtn        = document.getElementById('addVariantBtn');
            const simpleSection = document.getElementById('simpleStockSection');
            const hiddenInput   = document.getElementById('has_variants_hidden');

            hiddenInput.value = this.checked ? '1' : '0';

            if (this.checked) {
                unitSection.style.display = '';
                addBtn.style.display = '';
                simpleSection.style.display = 'none';
            } else {
                unitSection.style.display = 'none';
                addBtn.style.display = 'none';
                simpleSection.style.display = '';
            }
        });

        // Dynamic variant rows add/remove
        let variantIndex = {{ $product->productVariants->count() > 0 ? $product->productVariants->count() : 1 }};
        document.getElementById('addVariantBtn').addEventListener('click', function () {
            const wrapper = document.getElementById('variantWrapper');
            const newRow = document.querySelector('.variant-row').cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                if (input.type === 'hidden') {
                    input.remove();
                } else {
                    input.value = '';
                    input.name = input.name.replace(/\[\d+\]/, `[${variantIndex}]`);
                }
            });
            newRow.querySelectorAll('select').forEach(select => {
                select.name = select.name.replace(/\[\d+\]/, `[${variantIndex}]`);
                select.selectedIndex = 0;
            });

            const removeBtn = newRow.querySelector('.remove-variant');
            removeBtn.style.display = 'inline-block';
            removeBtn.addEventListener('click', function () {
                newRow.remove();
            });

            wrapper.appendChild(newRow);
            variantIndex++;
        });

        // Existing remove buttons (loaded from DB) — bind click event
        document.querySelectorAll('.remove-variant').forEach(btn => {
            btn.addEventListener('click', function () {
                this.closest('.variant-row').remove();
            });
        });

        document.getElementById('name').addEventListener('input', function (e) {
            const slugField = document.getElementById('slug');
            if (!slugField.dataset.userEdited) {
                slugField.value = e.target.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
            }
        });
        document.getElementById('slug').addEventListener('input', function () {
            this.dataset.userEdited = 'true';
        });

        document.getElementById('category_id').addEventListener('change', function () {
            const categoryId = this.value;
            const subCategorySelect = document.getElementById('sub_category_id');
            subCategorySelect.innerHTML = '<option value="">Loading...</option>';

            if (!categoryId) {
                subCategorySelect.innerHTML = '<option value="">Select Category First</option>';
                $(subCategorySelect).trigger('change');
                return;
            }

            fetch(`/superadmin/categories/${categoryId}/subcategories`)
                .then(res => res.json())
                .then(data => {
                    subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                    data.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.textContent = sub.name;
                        subCategorySelect.appendChild(opt);
                    });
                    $(subCategorySelect).trigger('change');
                })
                .catch(() => {
                    subCategorySelect.innerHTML = '<option value="">Failed to load</option>';
                    $(subCategorySelect).trigger('change');
                });
        });

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

        $(document).ready(function () {
            const priceInput      = document.getElementById('price');
            const percentInput    = document.getElementById('discount_percent');
            const discountInput   = document.getElementById('discount_price');

            function calculateDiscountPrice() {
                const price   = parseFloat(priceInput.value) || 0;
                const percent = parseFloat(percentInput.value) || 0;

                if (price > 0 && percent > 0) {
                    const discounted = price - (price * percent / 100);
                    discountInput.value = discounted.toFixed(2);
                }
            }

            function calculatePercentFromPrice() {
                const price    = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;

                if (price > 0 && discount > 0 && discount < price) {
                    const percent = ((price - discount) / price) * 100;
                    percentInput.value = percent.toFixed(2);
                }
            }

            priceInput.addEventListener('input', calculateDiscountPrice);
            percentInput.addEventListener('input', calculateDiscountPrice);
            discountInput.addEventListener('input', calculatePercentFromPrice);

            // product_type এখন business type (own/dropshipping/...), তাই দুই card সবসময় দেখাবে
            const productType = document.getElementById('product_type');
            const variantCard = document.getElementById('variantCard');
            const attributeCard = document.getElementById('attributeCard');
            function toggleSectionsByType() {
                variantCard.style.display = '';
                attributeCard.style.display = '';
            }
            $(productType).on('change', toggleSectionsByType);
            toggleSectionsByType();

            // পেজ খোলার সময় discount % আগের দাম থেকে হিসাব করে বসাও
            if (priceInput.value && discountInput.value) {
                calculatePercentFromPrice();
            }

            // Update button-এর click সরাসরি form submit করবে (create-এর মতো)
            const productForm = document.getElementById('productForm');
            productForm.querySelector('button[type=submit]').addEventListener('click', function (e) {
                e.preventDefault();
                productForm.submit();
            });
        });
    </script>

        <script>
        (function () {
            var wrapper = document.getElementById('specWrapper');
            var index   = {{ count($oldSpecs) }};

            function addRow(name, value) {
                var tr = document.createElement('tr');
                tr.className = 'spec-row';
                tr.innerHTML =
                    '<td><input type="text" name="specifications[' + index + '][name]" class="form-control form-control-sm" placeholder="e.g. Brand"></td>' +
                    '<td><input type="text" name="specifications[' + index + '][value]" class="form-control form-control-sm" placeholder="e.g. Panasonic"></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm remove-spec" title="Remove"><i class="bx bx-trash"></i></button></td>';
                tr.querySelector('input[name$="[name]"]').value  = name || '';
                tr.querySelector('input[name$="[value]"]').value = value || '';
                wrapper.appendChild(tr);
                index++;
            }

            function removeEmptyRows() {
                wrapper.querySelectorAll('.spec-row').forEach(function (tr) {
                    var n = tr.querySelector('input[name$="[name]"]').value.trim();
                    var v = tr.querySelector('input[name$="[value]"]').value.trim();
                    if (!n && !v) tr.remove();
                });
            }

            document.getElementById('addSpecBtn').addEventListener('click', function () { addRow('', ''); });

            wrapper.addEventListener('click', function (e) {
                var btn = e.target.closest('.remove-spec');
                if (!btn) return;
                btn.closest('.spec-row').remove();
            });

            var box = document.getElementById('bulkSpecBox');
            document.getElementById('bulkSpecBtn').addEventListener('click', function () {
                box.style.display = box.style.display === 'none' ? '' : 'none';
            });
            document.getElementById('bulkSpecCancel').addEventListener('click', function () {
                box.style.display = 'none';
            });
            document.getElementById('bulkSpecApply').addEventListener('click', function () {
                var lines = document.getElementById('bulkSpecText').value.split(/\r?\n/);
                var added = 0;
                removeEmptyRows();
                lines.forEach(function (line) {
                    line = line.trim();
                    if (!line) return;
                    var pos = line.indexOf(':');
                    if (pos === -1) { addRow(line, ''); }
                    else { addRow(line.substring(0, pos).trim(), line.substring(pos + 1).trim()); }
                    added++;
                });
                if (added) {
                    document.getElementById('bulkSpecText').value = '';
                    box.style.display = 'none';
                }
            });
        })();
    </script>

        <script>
        (function () {
            var input = document.getElementById('offer_images');
            if (!input) return;

            var box = document.getElementById('offerPreview');
            var max = 5;

            function remaining() {
                var existing = document.querySelectorAll('.offer-existing').length;
                var removed  = document.querySelectorAll('.offer-remove:checked').length;
                return max - (existing - removed);
            }

            function render() {
                box.innerHTML = '';
                Array.prototype.forEach.call(input.files, function (f) {
                    var img = document.createElement('img');
                    img.src = URL.createObjectURL(f);
                    img.style.cssText = 'width:80px;height:80px;object-fit:cover;border-radius:6px';
                    box.appendChild(img);
                });
            }

            input.addEventListener('change', function () {
                var left = remaining();
                if (input.files.length > left) {
                    alert('Maximum ' + max + ' ta image rakha jabe. Ekhon aro ' + Math.max(left, 0) + ' ta add korte parben.');
                    input.value = '';
                }
                render();
            });
        })();
    </script>
@endpush
