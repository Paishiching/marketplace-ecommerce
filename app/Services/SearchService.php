<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    /**
     * Search products by keyword with optional filters
     * (category, brand, vendor, price range) and sorting.
     */
    public function searchProducts(string $keyword = '', array $filters = [], string $sort = 'latest', int $perPage = 20): LengthAwarePaginator
    {
        $query = Product::query()->where('status', 'active');

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('sku', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        if (! empty($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }

        if (! empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (! empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        return $query->paginate($perPage);
    }

    /**
     * Lightweight autocomplete/suggestion search — just names and slugs.
     */
    public function suggest(string $keyword, int $limit = 8)
    {
        return Product::where('status', 'active')
            ->where('name', 'like', "%{$keyword}%")
            ->limit($limit)
            ->get(['id', 'name', 'slug', 'thumbnail', 'price']);
    }
}
