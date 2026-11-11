<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));
        $imageCategories = Category::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->with(['children' => fn ($query) => $query->where('status', true)])
            ->orderBy('name')
            ->get()
            ->flatMap(fn ($category) => collect([$category])->merge($category->children))
            ->take(30)
            ->values();

        $products = Product::query()
            ->with(['brand', 'primaryImage'])
            ->withCount('reviews')
            ->active()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('sku', 'like', "%{$q}%")
                        ->orWhere('short_description', 'like', "%{$q}%")
                        ->orWhereHas('brand', function ($brand) use ($q) {
                            $brand->where('name', 'like', "%{$q}%");
                        })
                        ->orWhereHas('productSpecifications', function ($spec) use ($q) {
                            $spec->where('name', 'like', '%model%')
                                ->where('value', 'like', "%{$q}%");
                        })
                        ->orWhereHas('productAttributes', function ($productAttribute) use ($q) {
                            $productAttribute->whereHas('attribute', function ($attribute) {
                                $attribute->where('name', 'like', '%model%');
                            })->whereHas('attributeValue', function ($value) use ($q) {
                                $value->where('value', 'like', "%{$q}%");
                            });
                        });
                });
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.search.index', compact('products', 'q', 'imageCategories'));
    }

    public function image(Request $request)
    {
        $imageCategories = Category::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->with(['children' => fn ($query) => $query->where('status', true)])
            ->orderBy('name')
            ->get()
            ->flatMap(fn ($category) => collect([$category])->merge($category->children))
            ->take(30)
            ->values();

        $request->validate(['image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]);
        if (! function_exists('imagecreatefromstring')) {
            return back()->withErrors(['image' => 'Image search is unavailable on this server. Please search by product name.']);
        }

        $query = $this->imageSignature(file_get_contents($request->file('image')->getRealPath()));
        if (! $query) {
            return back()->withErrors(['image' => 'We could not read that image. Try another JPG, PNG, or WebP image.']);
        }

        $ranked = [];
        // Keep image matching bounded so a large catalog cannot make one request
        // decode every product image synchronously.
        $candidates = Product::query()
            ->active()
            ->with('primaryImage')
            ->select(['id', 'thumbnail'])
            ->orderByDesc('id')
            ->limit(300)
            ->get();

        foreach ($candidates as $product) {
            $path = $product->thumbnail ?: $product->primaryImage?->image_path;
            if (! $path || preg_match('#^https?://#i', $path)) continue;
            $path = ltrim($path, '/');
            $fullPath = file_exists(public_path('storage/'.$path)) ? public_path('storage/'.$path)
                : (Storage::disk('public')->exists($path) ? Storage::disk('public')->path($path)
                : (file_exists(public_path($path)) ? public_path($path) : null));
            if (! $fullPath) continue;
            $signature = $this->imageSignature(@file_get_contents($fullPath));
            if (! $signature) continue;
            $distance = 0;
            foreach ($query as $i => $rgb) {
                foreach ($rgb as $channel => $value) $distance += ($value - $signature[$i][$channel]) ** 2;
            }
            $ranked[$product->id] = $distance;
        }

        asort($ranked);
        $ids = array_slice(array_keys($ranked), 0, 24);
        $products = Product::query()->whereIn('id', $ids)->with(['brand', 'primaryImage'])
            ->withCount('reviews')->get()
            ->sortBy(fn ($product) => array_search($product->id, $ids, true))->values();
        $q = '';
        return view('frontend.search.index', compact('products', 'q', 'imageCategories'))->with('imageSearch', true);
    }

    private function imageSignature(string|false $contents): ?array
    {
        if (! $contents) return null;
        $source = @imagecreatefromstring($contents);
        if (! $source) return null;
        $width = imagesx($source); $height = imagesy($source);
        if (!$width || !$height) { imagedestroy($source); return null; }
        $signature = [];
        for ($gy = 0; $gy < 4; $gy++) for ($gx = 0; $gx < 4; $gx++) {
            $color = imagecolorat($source, (int)(($gx + .5) * $width / 4), (int)(($gy + .5) * $height / 4));
            $signature[] = [($color >> 16) & 255, ($color >> 8) & 255, $color & 255];
        }
        imagedestroy($source);
        return $signature;
    }
}
