<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand', 'vendor'])
            ->when($request->query('status') === 'pending', fn ($q) => $q->where('status', 'pending'))
            ->latest('id')
            ->get();

        return view('superadmin.products.index', compact('products'));
    }

    public function approve(Product $product)
    {
        $product->update(['status' => 'published']);

        return back()->with('success', '"' . $product->name . '" approve hoyeche, ekhon website e live.');
    }

    public function reject(Product $product)
    {
        $product->update(['status' => 'rejected']);

        return back()->with('success', '"' . $product->name . '" reject kora hoyeche.');
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('status', 1)->get(['id', 'name']);
        $brands     = Brand::where('status', 1)->get(['id', 'name']);

        $vendors    = Vendor::where('status', 'approved')->get(['id', 'shop_name']);

        $colors = Attribute::where('name', 'Color')->first()?->attributeValues()->get(['id', 'value']) ?? collect();
        $sizes  = Attribute::where('name', 'Size')->first()?->attributeValues()->get(['id', 'value']) ?? collect();

        return view('superadmin.products.create', compact(
            'categories', 'brands', 'vendors', 'colors', 'sizes'
        ));
    }

    public function store(Request $request)
    {
        // unit variants বন্ধ থাকলে খালি row-গুলো বাদ দাও
        if (! $request->boolean('has_variants')) {
            $request->request->remove('variants');
        }

        $validated = $request->validate([
            'name'                       => ['required', 'string', 'max:255'],
            'slug'                       => ['nullable', 'string', 'max:255'],
            'sku'                        => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'short_description'          => ['nullable', 'string'],
            'description'                => ['nullable', 'string'],
            'category_id'                => ['required', 'exists:categories,id'],
            'sub_category_id'            => ['nullable', 'exists:categories,id'],
            'brand_id'                   => ['nullable', 'exists:brands,id'],
            'vendor_id'                  => ['nullable', 'exists:vendors,id'],
            'product_type'               => ['required', 'in:vendor,supplier,affiliate,dropshipping,wholesale,reseller'],
            'price'                      => ['required', 'numeric', 'min:0'],
            'discount_price'             => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'cost_price'                 => ['nullable', 'numeric', 'min:0'],
            'tags'                       => ['nullable', 'string'],
            'status'                     => ['required', 'in:draft,pending,published,rejected'],
            'is_new'                     => ['nullable', 'boolean'],
            'is_featured'                => ['nullable', 'boolean'],
            'is_hot'                     => ['nullable', 'boolean'],
            'thumbnail'                  => ['required', 'image', 'max:2048'],
            'gallery_images'             => ['nullable', 'array'],
            'gallery_images.*'           => ['image', 'max:2048'],
            'colors'                     => ['nullable', 'array'],
            'colors.*'                   => ['exists:attribute_values,id'],
            'sizes'                      => ['nullable', 'array'],
            'sizes.*'                    => ['exists:attribute_values,id'],
            'has_variants'               => ['nullable', 'boolean'],
            'simple_stock_quantity'      => ['nullable', 'integer', 'min:0'],
            'simple_sku'                 => ['nullable', 'string', 'max:100'],
            'variants'                   => ['nullable', 'array'],
            'variants.*.unit_type'       => ['required_with:variants', 'string'],
            'variants.*.unit_value'      => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.price'           => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.stock_quantity'  => ['required_with:variants', 'integer', 'min:0'],
            'variants.*.sku'             => ['nullable', 'string', 'max:100'],
            'specifications'             => ['nullable', 'array'],
            'specifications.*.name'      => ['nullable', 'string', 'max:255'],
            'specifications.*.value'     => ['nullable', 'string', 'max:2000'],
            'sponsored_video_url'        => ['nullable', 'url', 'max:500'],
            'offer_images'               => ['nullable', 'array', 'max:5'],
            'offer_images.*'             => ['image', 'max:2048'],
        ]);

        $newOfferPaths = [];

        DB::beginTransaction();

        try {
            $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');

            $product = Product::create([
                'vendor_id'           => $validated['vendor_id'] ?? null,
                'category_id'         => $validated['category_id'],
                'sub_category_id'     => $validated['sub_category_id'] ?? null,
                'brand_id'            => $validated['brand_id'] ?? null,
                'name'                => $validated['name'],
                'slug'                => $this->uniqueSlug($validated['slug'] ?: $validated['name']),
                'sku'                 => $validated['sku'] ?? null,
                'description'         => $validated['description'] ?? null,
                'price'               => $validated['price'],
                'discount_price'      => $validated['discount_price'] ?? null,
                'product_type'        => $validated['product_type'],
                'short_description'   => $validated['short_description'] ?? null,
                'cost_price'          => $validated['cost_price'] ?? null,
                'tags'                => $validated['tags'] ?? null,
                'thumbnail'           => $thumbnailPath,
                'sponsored_video_url' => $validated['sponsored_video_url'] ?? null,
                'status'              => $validated['status'],
                'is_new'              => $request->boolean('is_new'),
                'is_featured'         => $request->boolean('is_featured'),
                'is_hot'              => $request->boolean('is_hot'),
            ]);

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $image) {
                    $path = $image->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => false,
                        'sort_order' => $index,
                    ]);
                }
            }

            $newOfferPaths = $this->storeOfferImages($product, $request, 0);

            $this->syncProductAttributes($product, $validated['colors'] ?? [], 'Color');
            $this->syncProductAttributes($product, $validated['sizes'] ?? [], 'Size');
            $this->syncProductSpecifications($product, $validated['specifications'] ?? []);

            if ($request->boolean('has_variants') && ! empty($validated['variants'])) {
                $this->syncProductVariants($product, $validated['variants']);
            } elseif ($request->filled('simple_stock_quantity') || $request->filled('simple_sku')) {
                // simple product, single implicit variant carrying stock/sku
                $product->productVariants()->create([
                    'unit_type'      => 'piece',
                    'unit_value'     => 1,
                    'price'          => $validated['price'],
                    'stock_quantity' => $validated['simple_stock_quantity'] ?? 0,
                    'sku'            => $validated['simple_sku'] ?? null,
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            if (isset($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            foreach ($newOfferPaths as $p) {
                Storage::disk('public')->delete($p);
            }

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->route('superadmin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'subCategory', 'brand', 'vendor', 'productImages', 'colorValues', 'sizeValues', 'productSpecifications', 'offerImages']);

        return view('superadmin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['productImages', 'colorValues', 'sizeValues', 'productVariants', 'productSpecifications', 'offerImages']);

        $categories = Category::whereNull('parent_id')->where('status', 1)->get(['id', 'name']);
        $subCategories = Category::where('parent_id', $product->category_id)->get(['id', 'name']);
        $brands     = Brand::where('status', 1)->get(['id', 'name']);
        $vendors    = Vendor::where('status', 'approved')->get(['id', 'shop_name']);

        $colors = Attribute::where('name', 'Color')->first()?->attributeValues()->get(['id', 'value']) ?? collect();
        $sizes  = Attribute::where('name', 'Size')->first()?->attributeValues()->get(['id', 'value']) ?? collect();

        return view('superadmin.products.edit', compact(
            'product', 'categories', 'subCategories', 'brands', 'vendors', 'colors', 'sizes'
        ));
    }

    public function update(Request $request, Product $product)
    {
        // unit variants বন্ধ থাকলে hidden খালি row-গুলো validation থেকে বাদ দাও
        if (! $request->boolean('has_variants')) {
            $request->request->remove('variants');
        }

        $validated = $request->validate([
            'name'                       => ['required', 'string', 'max:255'],
            'slug'                       => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'sku'                        => ['nullable', 'string', 'max:100', 'unique:products,sku,' . $product->id],
            'short_description'          => ['nullable', 'string'],
            'description'                => ['nullable', 'string'],
            'category_id'                => ['required', 'exists:categories,id'],
            'sub_category_id'            => ['nullable', 'exists:categories,id'],
            'brand_id'                   => ['nullable', 'exists:brands,id'],
            'vendor_id'                  => ['nullable', 'exists:vendors,id'],
            'product_type'               => ['required', 'in:vendor,supplier,affiliate,dropshipping,wholesale,reseller'],
            'price'                      => ['required', 'numeric', 'min:0'],
            'discount_price'             => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'cost_price'                 => ['nullable', 'numeric', 'min:0'],
            'tags'                       => ['nullable', 'string'],
            'status'                     => ['required', 'in:draft,pending,published,rejected'],
            'is_new'                     => ['nullable', 'boolean'],
            'is_featured'                => ['nullable', 'boolean'],
            'is_hot'                     => ['nullable', 'boolean'],
            'thumbnail'                  => ['nullable', 'image', 'max:2048'],
            'gallery_images'             => ['nullable', 'array'],
            'gallery_images.*'           => ['image', 'max:2048'],
            'colors'                     => ['nullable', 'array'],
            'colors.*'                   => ['exists:attribute_values,id'],
            'sizes'                      => ['nullable', 'array'],
            'sizes.*'                    => ['exists:attribute_values,id'],
            'has_variants'               => ['nullable', 'boolean'],
            'simple_stock_quantity'      => ['nullable', 'integer', 'min:0'],
            'simple_sku'                 => ['nullable', 'string', 'max:100'],
            'variants'                   => ['nullable', 'array'],
            'variants.*.id'              => ['nullable', 'integer', 'exists:product_variants,id'],
            'variants.*.unit_type'       => ['required_with:variants', 'string'],
            'variants.*.unit_value'      => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.price'           => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.stock_quantity'  => ['required_with:variants', 'integer', 'min:0'],
            'variants.*.sku'             => ['nullable', 'string', 'max:100'],
            'specifications'             => ['nullable', 'array'],
            'specifications.*.name'      => ['nullable', 'string', 'max:255'],
            'specifications.*.value'     => ['nullable', 'string', 'max:2000'],
            'sponsored_video_url'        => ['nullable', 'url', 'max:500'],
            'offer_images'               => ['nullable', 'array', 'max:5'],
            'offer_images.*'             => ['image', 'max:2048'],
            'remove_offer_images'        => ['nullable', 'array'],
            'remove_offer_images.*'      => ['integer'],
        ]);

        // Offer image : moot 5 tar beshi rakha jabe na (ager thaka - remove kora + notun)
        $removeIds = collect($validated['remove_offer_images'] ?? [])->map(fn ($id) => (int) $id)->all();
        $keepCount = $product->offerImages()->whereNotIn('id', $removeIds)->count();
        $newCount  = count($request->file('offer_images', []));

        if ($keepCount + $newCount > 5) {
            return back()->withInput()->withErrors([
                'offer_images' => 'Maximum 5 ta offer image rakha jabe (ekhon ' . $keepCount . ' ta ache).',
            ]);
        }

        $newOfferPaths = [];
        $pathsToDelete = [];

        DB::beginTransaction();

        try {
            $oldThumbnail = $product->thumbnail;
            $thumbnailPath = $oldThumbnail;

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            $product->update([
                'vendor_id'           => $validated['vendor_id'] ?? null,
                'category_id'         => $validated['category_id'],
                'sub_category_id'     => $validated['sub_category_id'] ?? null,
                'brand_id'            => $validated['brand_id'] ?? null,
                'name'                => $validated['name'],
                'slug'                => $validated['slug'] ?? $product->slug,
                'sku'                 => $validated['sku'] ?? null,
                'description'         => $validated['description'] ?? null,
                'price'               => $validated['price'],
                'discount_price'      => $validated['discount_price'] ?? null,
                'product_type'        => $validated['product_type'],
                'short_description'   => $validated['short_description'] ?? null,
                'cost_price'          => $validated['cost_price'] ?? null,
                'tags'                => $validated['tags'] ?? null,
                'thumbnail'           => $thumbnailPath,
                'sponsored_video_url' => $validated['sponsored_video_url'] ?? null,
                'status'              => $validated['status'],
                'is_new'              => $request->boolean('is_new'),
                'is_featured'         => $request->boolean('is_featured'),
                'is_hot'              => $request->boolean('is_hot'),
            ]);

            if ($request->hasFile('thumbnail') && $oldThumbnail) {
                $pathsToDelete[] = $oldThumbnail;
            }

            if ($request->hasFile('gallery_images')) {
                $startOrder = $product->productImages()->max('sort_order') + 1;

                foreach ($request->file('gallery_images') as $index => $image) {
                    $path = $image->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => false,
                        'sort_order' => $startOrder + $index,
                    ]);
                }
            }

            // Offer image : tick deya gulo muche, notun gulo add
            if (! empty($removeIds)) {
                foreach ($product->offerImages()->whereIn('id', $removeIds)->get() as $offerImg) {
                    $pathsToDelete[] = $offerImg->image_path;
                    $offerImg->delete();
                }
            }

            $offerStart    = (int) $product->offerImages()->max('sort_order') + 1;
            $newOfferPaths = $this->storeOfferImages($product, $request, $offerStart);

            $this->syncProductAttributes($product, $validated['colors'] ?? [], 'Color');
            $this->syncProductAttributes($product, $validated['sizes'] ?? [], 'Size');
            $this->syncProductSpecifications($product, $validated['specifications'] ?? []);

            if ($request->boolean('has_variants') && ! empty($validated['variants'])) {
                $this->syncProductVariants($product, $validated['variants']);
            } else {
                // simple mode — collapse to a single implicit variant, or clear variants entirely
                $product->productVariants()->delete();

                if ($request->filled('simple_stock_quantity') || $request->filled('simple_sku')) {
                    $product->productVariants()->create([
                        'unit_type'      => 'piece',
                        'unit_value'     => 1,
                        'price'          => $validated['price'],
                        'stock_quantity' => $validated['simple_stock_quantity'] ?? 0,
                        'sku'            => $validated['simple_sku'] ?? null,
                    ]);
                }
            }

            DB::commit();

            // commit hoyar por purano file gulo muche felo
            foreach ($pathsToDelete as $p) {
                Storage::disk('public')->delete($p);
            }
        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($newOfferPaths as $p) {
                Storage::disk('public')->delete($p);
            }

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect(route('superadmin.products.index') . '#product-' . $product->id)
            ->with('success', 'Product updated successfully.');
    }

    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base) ?: 'product';
        $original = $slug;
        $i = 2;

        while (
            Product::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            foreach ($product->productImages as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            foreach ($product->offerImages as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $product->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Could not delete product: ' . $e->getMessage());
        }

        return redirect()->route('superadmin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Sponsored popup er offer image gulo save kore. Save howa path gulo return kore
     * (error hole oi file gulo muchte).
     */
    private function storeOfferImages(Product $product, Request $request, int $startOrder = 0): array
    {
        $paths = [];

        foreach ($request->file('offer_images', []) as $i => $image) {
            $path = $image->store('products/offers', 'public');
            $paths[] = $path;

            $product->offerImages()->create([
                'image_path' => $path,
                'sort_order' => $startOrder + $i,
            ]);
        }

        return $paths;
    }

    /**
     * Given selected attribute_value ids and an attribute name (Color/Size),
     * remove old links for that attribute and create fresh ones.
     */
    private function syncProductAttributes(Product $product, array $valueIds, string $attributeName): void
    {
        $attribute = Attribute::where('name', $attributeName)->first();

        if (! $attribute) {
            return;
        }

        $product->productAttributes()
            ->where('attribute_id', $attribute->id)
            ->delete();

        foreach ($valueIds as $valueId) {
            ProductAttribute::create([
                'product_id'         => $product->id,
                'attribute_id'       => $attribute->id,
                'attribute_value_id' => $valueId,
            ]);
        }
    }

    /**
     * Specification rows (name + value) : purano shob muche notun kore save kore.
     * Name khali thakle oi row skip hobe.
     */
    private function syncProductSpecifications(Product $product, array $rows): void
    {
        $product->productSpecifications()->delete();

        $order = 0;

        foreach ($rows as $row) {
            $name  = trim((string) ($row['name'] ?? ''));
            $value = trim((string) ($row['value'] ?? ''));

            if ($name === '') {
                continue;
            }

            $product->productSpecifications()->create([
                'name'       => $name,
                'value'      => $value !== '' ? $value : null,
                'sort_order' => $order++,
            ]);
        }
    }

    /**
     * Create/update unit variant rows submitted from the form, and
     * delete any existing variant rows the user removed in the UI.
     */
    private function syncProductVariants(Product $product, array $variants): void
    {
        $keepIds = [];

        foreach ($variants as $row) {
            if (empty($row['unit_value']) || ! isset($row['price'])) {
                continue;
            }

            if (! empty($row['id'])) {
                $variant = $product->productVariants()->find($row['id']);

                if ($variant) {
                    $variant->update([
                        'unit_type'      => $row['unit_type'],
                        'unit_value'     => $row['unit_value'],
                        'price'          => $row['price'],
                        'stock_quantity' => $row['stock_quantity'] ?? 0,
                        'sku'            => $row['sku'] ?? null,
                    ]);
                } else {
                    $variant = $product->productVariants()->create([
                        'unit_type'      => $row['unit_type'],
                        'unit_value'     => $row['unit_value'],
                        'price'          => $row['price'],
                        'stock_quantity' => $row['stock_quantity'] ?? 0,
                        'sku'            => $row['sku'] ?? null,
                    ]);
                }
            } else {
                $variant = $product->productVariants()->create([
                    'unit_type'      => $row['unit_type'],
                    'unit_value'     => $row['unit_value'],
                    'price'          => $row['price'],
                    'stock_quantity' => $row['stock_quantity'] ?? 0,
                    'sku'            => $row['sku'] ?? null,
                ]);
            }

            $keepIds[] = $variant->id;
        }

        $product->productVariants()->whereNotIn('id', $keepIds)->delete();
    }
}