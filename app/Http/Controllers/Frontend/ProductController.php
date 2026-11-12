<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load([
            'category', 'subCategory', 'brand', 'vendor',
            'productImages', 'colorValues', 'sizeValues',
            'productVariants', 'reviews',
            'productSpecifications', 'productEmiPlans',
        ]);

        // "You Might Also Like" — একই category থেকে random কিছু প্রোডাক্ট, বর্তমানটা বাদ দিয়ে
        $relatedProducts = Product::with(['productImages'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            // Avoid ORDER BY RAND() on a large catalog; keep the related list index-friendly.
            ->latest('id')
            ->limit(8)
            ->get();

        // "Other Products In The Same Category" — একই category, latest অনুযায়ী
        $sameCategoryProducts = Product::with(['productImages'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->latest('id')
            ->limit(16)
            ->get();

        return view('frontend.products.show', compact(
            'product', 'relatedProducts', 'sameCategoryProducts'
        ));
    }
}
