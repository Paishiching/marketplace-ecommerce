<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Route: categories-index  =>  frontend.categories.index
     */
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', true)
            ->with('children')
            ->get();

        $products = $this->applyFilters(Product::query(), $request)
            ->paginate(12)
            ->withQueryString();

        return view('frontend.categories.index', compact('categories', 'products'));
    }

    /**
     * Route: categories-shop  =>  frontend.categories.shop
     */
    public function shop(Request $request)
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', true)
            ->with('children')
            ->get();

        $brands = Brand::where('status', true)->withCount('products')->get();

        $products = $this->applyFilters(Product::query(), $request)
            ->paginate(12)
            ->withQueryString();

        return view('frontend.categories.shop', compact('categories', 'brands', 'products'));
    }

    /**
     * Common filter + sort + eager-load logic — দুইটা view এর জন্যই ব্যবহার হবে
     */
    protected function applyFilters($query, Request $request)
    {
        // Product cards need one image plus aggregate review values; loading every
        // image, review, and inventory row per product makes catalog pages heavy.
        $query->active()
            ->with(['primaryImage', 'brand', 'category'])
            ->withCount('reviews');

        // Category filter (?category=slug)
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where(function ($q) use ($category) {
                    $q->where('category_id', $category->id)
                        ->orWhere('sub_category_id', $category->id);
                });
            }
        }

        // Brand filter (?brands[]=slug1&brands[]=slug2)
        if ($request->filled('brands')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->whereIn('slug', $request->brands);
            });
        }

        // Price filter (?min_price=&max_price=)
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereBetween('price', [
                (float) $request->input('min_price', 0),
                (float) $request->input('max_price', 999999),
            ]);
        }

        // Size filter (?sizes[]=M&sizes[]=L)
        if ($request->filled('sizes')) {
            $query->whereHas('sizeValues', function ($q) use ($request) {
                $q->whereIn('value', $request->sizes);
            });
        }

        // Colour filter (?colors[]=Black)
        if ($request->filled('colors')) {
            $query->whereHas('colorValues', function ($q) use ($request) {
                $q->whereIn('value', $request->colors);
            });
        }

        // Sort (?sort=a-z|z-a|in_stock)
        switch ($request->input('sort')) {
            case 'a-z':
                $query->orderBy('name', 'asc');
                break;
            case 'z-a':
                $query->orderBy('name', 'desc');
                break;
            case 'in_stock':
                $query->inStock()->latest();
                break;
            default:
                $query->latest();
        }

        return $query;
    }
}
