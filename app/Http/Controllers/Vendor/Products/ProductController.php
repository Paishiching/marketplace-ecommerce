<?php

namespace App\Http\Controllers\Vendor\Products;

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
    public function index()
    {
        $vendor = $this->vendor();

        $products = Product::with(['category', 'brand'])
            ->where('vendor_id', $vendor->id)
            ->latest('id')
            ->paginate(15);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $this->vendor();

        return view('vendor.products.create', $this->formData());
    }

    public function store(Request $request)
    {
        $vendor = $this->vendor();

        if (! $request->boolean('has_variants')) {
            $request->request->remove('variants');
        }

        $validated = $request->validate($this->rules());

        DB::beginTransaction();

        try {
            $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');

            $product = Product::create([
                'vendor_id'         => $vendor->id,            // auto, form theke ashe na
                'category_id'       => $validated['category_id'],
                'sub_category_id'   => $validated['sub_category_id'] ?? null,
                'brand_id'          => $validated['brand_id'] ?? null,
                'name'              => $validated['name'],
                'slug'              => $this->uniqueSlug($validated['name']),
                'sku'               => $validated['sku'] ?? null,
                'description'       => $validated['description'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'price'             => $validated['price'],
                'discount_price'    => $validated['discount_price'] ?? null,
                'cost_price'        => $validated['cost_price'] ?? null,
                'tags'              => $validated['tags'] ?? null,
                'product_type'      => 'vendor',
                'thumbnail'         => $thumbnailPath,
                'status'            => 'pending',              // admin approve korle published hobe
                'is_new'            => false,
                'is_featured'       => false,
                'is_hot'            => false,
            ]);

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $image) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $image->store('products/gallery', 'public'),
                        'is_primary' => false,
                        'sort_order' => $index,
                    ]);
                }
            }

            $this->syncProductAttributes($product, $validated['colors'] ?? [], 'Color');
            $this->syncProductAttributes($product, $validated['sizes'] ?? [], 'Size');

            if ($request->boolean('has_variants') && ! empty($validated['variants'])) {
                $this->syncProductVariants($product, $validated['variants']);
            } elseif ($request->filled('simple_stock_quantity') || $request->filled('simple_sku')) {
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

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->route('vendor.products.products.index')
            ->with('success', 'Product jomma hoyeche. Admin approve korle website e live hobe.');
    }

    public function show($id)
    {
        return redirect()->route('vendor.products.products.edit', $id);
    }

    public function edit($id)
    {
        $vendor  = $this->vendor();
        $product = $this->ownProduct($vendor, $id);
        $product->load(['productImages', 'colorValues', 'sizeValues', 'productVariants']);

        $subCategories = Category::where('parent_id', $product->category_id)->get(['id', 'name']);

        return view('vendor.products.edit', $this->formData() + compact('product', 'subCategories'));
    }

    public function update(Request $request, $id)
    {
        $vendor  = $this->vendor();
        $product = $this->ownProduct($vendor, $id);

        if (! $request->boolean('has_variants')) {
            $request->request->remove('variants');
        }

        $rules = $this->rules($product->id);
        $rules['thumbnail'] = ['nullable', 'image', 'max:2048'];
        $rules['variants.*.id'] = ['nullable', 'integer', 'exists:product_variants,id'];

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            $oldThumbnail  = $product->thumbnail;
            $thumbnailPath = $oldThumbnail;

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            $product->update([
                'category_id'       => $validated['category_id'],
                'sub_category_id'   => $validated['sub_category_id'] ?? null,
                'brand_id'          => $validated['brand_id'] ?? null,
                'name'              => $validated['name'],
                'sku'               => $validated['sku'] ?? null,
                'description'       => $validated['description'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'price'             => $validated['price'],
                'discount_price'    => $validated['discount_price'] ?? null,
                'cost_price'        => $validated['cost_price'] ?? null,
                'tags'              => $validated['tags'] ?? null,
                'thumbnail'         => $thumbnailPath,
                'status'            => 'pending',   // edit korle abar admin approval lagbe
            ]);

            if ($request->hasFile('thumbnail') && $oldThumbnail) {
                Storage::disk('public')->delete($oldThumbnail);
            }

            if ($request->hasFile('gallery_images')) {
                $startOrder = $product->productImages()->max('sort_order') + 1;

                foreach ($request->file('gallery_images') as $index => $image) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $image->store('products/gallery', 'public'),
                        'is_primary' => false,
                        'sort_order' => $startOrder + $index,
                    ]);
                }
            }

            $this->syncProductAttributes($product, $validated['colors'] ?? [], 'Color');
            $this->syncProductAttributes($product, $validated['sizes'] ?? [], 'Size');

            if ($request->boolean('has_variants') && ! empty($validated['variants'])) {
                $this->syncProductVariants($product, $validated['variants']);
            } else {
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
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->route('vendor.products.products.index')
            ->with('success', 'Product update hoyeche. Admin abar approve korle live hobe.');
    }

    public function destroy($id)
    {
        $vendor  = $this->vendor();
        $product = $this->ownProduct($vendor, $id);

        DB::beginTransaction();

        try {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            foreach ($product->productImages as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $product->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Could not delete product: ' . $e->getMessage());
        }

        return redirect()->route('vendor.products.products.index')->with('success', 'Product deleted.');
    }

    // Category -> SubCategory dropdown er jonno (superadmin route vendor ke 403 dey)
    public function subCategories($category)
    {
        $this->vendor();

        return response()->json(
            Category::where('parent_id', $category)->where('status', 1)->get(['id', 'name'])
        );
    }

    /* ---------------- helpers ---------------- */

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }

    // onner vendor er product dile 404
    private function ownProduct(Vendor $vendor, $id): Product
    {
        return Product::where('vendor_id', $vendor->id)->findOrFail($id);
    }

    private function formData(): array
    {
        return [
            'categories' => Category::whereNull('parent_id')->where('status', 1)->get(['id', 'name']),
            'brands'     => Brand::where('status', 1)->get(['id', 'name']),
            'colors'     => Attribute::where('name', 'Color')->first()?->attributeValues()->get(['id', 'value']) ?? collect(),
            'sizes'      => Attribute::where('name', 'Size')->first()?->attributeValues()->get(['id', 'value']) ?? collect(),
        ];
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'name'                      => ['required', 'string', 'max:255'],
            'sku'                       => ['nullable', 'string', 'max:100', 'unique:products,sku' . ($ignoreId ? ',' . $ignoreId : '')],
            'short_description'         => ['nullable', 'string'],
            'description'               => ['nullable', 'string'],
            'category_id'               => ['required', 'exists:categories,id'],
            'sub_category_id'           => ['nullable', 'exists:categories,id'],
            'brand_id'                  => ['nullable', 'exists:brands,id'],
            'price'                     => ['required', 'numeric', 'min:0'],
            'discount_price'            => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'cost_price'                => ['nullable', 'numeric', 'min:0'],
            'tags'                      => ['nullable', 'string'],
            'thumbnail'                 => ['required', 'image', 'max:2048'],
            'gallery_images'            => ['nullable', 'array'],
            'gallery_images.*'          => ['image', 'max:2048'],
            'colors'                    => ['nullable', 'array'],
            'colors.*'                  => ['exists:attribute_values,id'],
            'sizes'                     => ['nullable', 'array'],
            'sizes.*'                   => ['exists:attribute_values,id'],
            'has_variants'              => ['nullable', 'boolean'],
            'simple_stock_quantity'     => ['nullable', 'integer', 'min:0'],
            'simple_sku'                => ['nullable', 'string', 'max:100'],
            'variants'                  => ['nullable', 'array'],
            'variants.*.unit_type'      => ['required_with:variants', 'string'],
            'variants.*.unit_value'     => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.price'          => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.stock_quantity' => ['required_with:variants', 'integer', 'min:0'],
            'variants.*.sku'            => ['nullable', 'string', 'max:100'],
        ];
    }

    private function uniqueSlug(string $base): string
    {
        $slug     = Str::slug($base) ?: 'product';
        $original = $slug;
        $i        = 2;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    private function syncProductAttributes(Product $product, array $valueIds, string $attributeName): void
    {
        $attribute = Attribute::where('name', $attributeName)->first();

        if (! $attribute) {
            return;
        }

        $product->productAttributes()->where('attribute_id', $attribute->id)->delete();

        foreach ($valueIds as $valueId) {
            ProductAttribute::create([
                'product_id'         => $product->id,
                'attribute_id'       => $attribute->id,
                'attribute_value_id' => $valueId,
            ]);
        }
    }

    private function syncProductVariants(Product $product, array $variants): void
    {
        $keepIds = [];

        foreach ($variants as $row) {
            if (empty($row['unit_value']) || ! isset($row['price'])) {
                continue;
            }

            $data = [
                'unit_type'      => $row['unit_type'],
                'unit_value'     => $row['unit_value'],
                'price'          => $row['price'],
                'stock_quantity' => $row['stock_quantity'] ?? 0,
                'sku'            => $row['sku'] ?? null,
            ];

            $variant = ! empty($row['id']) ? $product->productVariants()->find($row['id']) : null;

            if ($variant) {
                $variant->update($data);
            } else {
                $variant = $product->productVariants()->create($data);
            }

            $keepIds[] = $variant->id;
        }

        $product->productVariants()->whereNotIn('id', $keepIds)->delete();
    }
}

