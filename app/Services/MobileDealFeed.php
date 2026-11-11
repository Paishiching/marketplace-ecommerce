<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class MobileDealFeed
{
    private const PER_PAGE = 24;

    /**
     * Return a small, cached batch so the mobile dock can rotate through the
     * full active product catalog without rendering every product image at once.
     *
     * @return array{items: array<int, array{id: int, name: string, slug: string, image: string}>, has_more: bool}
     */
    public function page(int $page): array
    {
        $page = max(1, $page);

        return Cache::remember("mobile_deal_feed.v1.page.{$page}", now()->addMinutes(5), function () use ($page) {
            $products = Product::query()
                ->where('status', true)
                ->whereNotNull('slug')
                ->where('slug', '<>', '')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereNotNull('thumbnail')->where('thumbnail', '<>', '');
                    })->orWhereHas('primaryImage');
                })
                ->with('primaryImage')
                ->orderByDesc('id')
                ->skip(($page - 1) * self::PER_PAGE)
                ->take(self::PER_PAGE + 1)
                ->get();

            return [
                'items' => $products->take(self::PER_PAGE)->map(fn (Product $product) => [
                    'id' => (int) $product->id,
                    'name' => (string) $product->name,
                    'slug' => (string) $product->slug,
                    'image' => $product->display_image,
                ])->values()->all(),
                'has_more' => $products->count() > self::PER_PAGE,
            ];
        });
    }
}
