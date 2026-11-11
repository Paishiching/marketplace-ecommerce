<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\MobileDealFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $homeData = Cache::remember('storefront.home.data.v2', now()->addSeconds(45), function () {
            // ---------- Banners (Admin > Banners e position onujayi) ----------
            $heroMain = Banner::active()->position('hero_main')->ordered()->get();

        // Side banner : duita position er SOB active banner (mobile e 4ta tile, 4 er beshi hole slide)
            $heroSides = Banner::active()
                ->whereIn('position', ['hero_side_top', 'hero_side_bottom'])
                ->ordered()
                ->get();

        // Ager variable gulo compatible rakha holo
            $heroSideTop = $heroSides->firstWhere('position', 'hero_side_top');
            $heroSideBot = $heroSides->firstWhere('position', 'hero_side_bottom');

            $promoStrip = Banner::active()->position('promo_strip')->ordered()->first();
            $dualLeft   = Banner::active()->position('dual_left')->ordered()->first();
            $dualRight  = Banner::active()->position('dual_right')->ordered()->first();

        // ---------- Root categories (product beshi gulo age) ----------
            $rootCategories = Category::whereNull('parent_id')
                ->where('status', 1)
                ->withCount('products')
                ->orderByDesc('products_count')
                ->get();

        // Featured Categories row
            $featuredCategories = $rootCategories->take(12);

        // ---------- Hot Deals: sobcheye beshi discount age ----------
            $hotDeals = $this->baseProducts()
                ->whereNotNull('discount_price')
                ->whereColumn('discount_price', '<', 'price')
                ->orderByRaw($this->discountOrderSql())
                ->limit(10)
                ->get();

        // ---------- Category wise product sections ----------
            $categorySections = $this->buildCategorySections($rootCategories);
            $featuredBrands = Brand::query()
                ->where('status', true)
                ->whereHas('products', fn ($query) => $query->where('status', 1))
                ->orderBy('name')
                ->limit(24)
                ->get(['id', 'name', 'slug', 'logo']);

            return compact(
                'heroMain', 'heroSides', 'heroSideTop', 'heroSideBot',
                'promoStrip', 'dualLeft', 'dualRight',
                'featuredCategories', 'hotDeals', 'categorySections', 'featuredBrands'
            );
        });

        return view('frontend.home.index', $homeData);
    }

    public function mobileDealFeed(Request $request, MobileDealFeed $feed)
    {
        return response()->json($feed->page(max(1, $request->integer('page', 1))));
    }

    /**
     * config/home.php te 'sections' thakle oigulo (custom title + category slug/naam),
     * na thakle (ba kono section na mille) product beshi thaka top root category gulo.
     */
    private function buildCategorySections($rootCategories)
    {
        $configured = collect(config('home.sections', []));
        $sections   = collect();

        if ($configured->isNotEmpty()) {
            $sections = $configured
                ->map(function ($cfg) {
                    // 'category' ekta string ba array (slug, tarpor naam gulo) dutoi cholbe
                    $keys = array_values(array_filter(
                        array_map(fn ($k) => trim((string) $k), (array) ($cfg['category'] ?? [])),
                        fn ($k) => $k !== ''
                    ));

                    if (empty($keys)) {
                        return null;
                    }

                    $category = $this->findCategory($keys);

                    if (!$category) {
                        Log::warning('Home section category not found: ' . implode(' | ', $keys));
                        return null;
                    }

                    $section = $this->fillSection(
                        $category,
                        $cfg['title'] ?? $category->name,
                        (int) ($cfg['limit'] ?? 10),
                        $cfg['order'] ?? 'latest'
                    );

                    if (!$section) {
                        Log::warning('Home section has no active product: ' . $category->name);
                    }

                    return $section;
                })
                ->filter()
                ->values();
        }

        // Config e kono section na mille / kono category na mille auto fallback
        if ($sections->isEmpty()) {
            $sections = $rootCategories
                ->take(6)
                ->map(fn ($category) => $this->fillSection($category, $category->name, 10, 'latest'))
                ->filter()
                ->values();
        }

        return $sections;
    }

    /**
     * Category khuje ber kore. Prothome shob key er jonno exact match (slug / naam),
     * na pele naam er ongsho diye (choto key, jemon "AC", er jonno ongsho match kora hoy na, bhul category dhorbe).
     */
    private function findCategory(array $keys): ?Category
    {
        foreach ($keys as $key) {
            $found = Category::where('status', 1)
                ->where(function ($q) use ($key) {
                    $q->where('slug', $key)
                      ->orWhere('slug', Str::slug($key))
                      ->orWhereRaw('LOWER(name) = ?', [mb_strtolower($key)]);
                })
                ->orderByRaw('slug = ? DESC', [$key])
                ->first();

            if ($found) {
                return $found;
            }
        }

        foreach ($keys as $key) {
            if (mb_strlen($key) < 4) {
                continue;
            }

            $found = Category::where('status', 1)
                ->where('name', 'like', '%' . str_replace('-', ' ', $key) . '%')
                ->first();

            if ($found) {
                return $found;
            }
        }

        return null;
    }

    /**
     * Category + tar sub category er product ene section banay. Product na thakle null.
     * $order: latest | discount | best_selling
     */
    private function fillSection(Category $category, string $title, int $limit, string $order)
    {
        $ids = Category::where('parent_id', $category->id)
            ->pluck('id')
            ->push($category->id);

        $query = $this->baseProducts()
            ->where(function ($q) use ($ids) {
                $q->whereIn('category_id', $ids)
                  ->orWhereIn('sub_category_id', $ids);
            });

        if ($order === 'discount') {
            $query->orderByRaw($this->discountOrderSql());
        } elseif ($order === 'best_selling') {
            $this->applyBestSellingOrder($query);
        }

        // tie-breaker / default
        $query->latest('id');

        $products = $query->limit(max(1, $limit))->get();

        if ($products->isEmpty()) {
            return null;
        }

        $category->section_title   = $title;
        $category->sectionProducts = $products;

        return $category;
    }

    /**
     * Best selling order. Ei sequence e chesta kore:
     *  1) products table er sold column (sold_count, total_sold ...)
     *  2) order_items / order_details table theke quantity sum
     *  3) products.is_hot flag
     */
    private function applyBestSellingOrder($query): void
    {
        $soldColumn = $this->soldColumn();
        if ($soldColumn) {
            $query->orderByDesc($soldColumn);
            return;
        }

        foreach (['order_items', 'order_details'] as $table) {
            if (Schema::hasTable($table)
                && Schema::hasColumn($table, 'product_id')
                && Schema::hasColumn($table, 'quantity')) {

                $query->orderByDesc(
                    DB::table($table)
                        ->selectRaw('COALESCE(SUM(quantity), 0)')
                        ->whereColumn($table . '.product_id', 'products.id')
                );
                return;
            }
        }

        if (Schema::hasColumn('products', 'is_hot')) {
            $query->orderByDesc('is_hot');
        }
    }

    private function discountOrderSql(): string
    {
        return 'CASE WHEN discount_price IS NOT NULL AND discount_price < price AND price > 0
                     THEN (price - discount_price) / price ELSE 0 END DESC';
    }

    /**
     * Product card e rating, review count ar image lage, tai eager load (N+1 hobe na).
     */
    private function baseProducts()
    {
        $query = Product::query()
            ->where('status', 1)
            ->with('primaryImage')
            ->withCount('reviews');

        $ratingColumn = $this->ratingColumn();
        if ($ratingColumn) {
            $query->withAvg('reviews as avg_rating', $ratingColumn);
        }

        return $query;
    }

    private function ratingColumn(): ?string
    {
        static $column = false;

        if ($column === false) {
            $column = null;
            if (Schema::hasTable('reviews')) {
                foreach (['rating', 'ratings', 'star', 'stars', 'review_rating', 'rate', 'score'] as $name) {
                    if (Schema::hasColumn('reviews', $name)) {
                        $column = $name;
                        break;
                    }
                }
            }
        }

        return $column;
    }

    /**
     * Best selling er jonno products table er sold column auto-detect.
     */
    private function soldColumn(): ?string
    {
        static $column = false;

        if ($column === false) {
            $column = null;
            if (Schema::hasTable('products')) {
                foreach (['sold_count', 'total_sold', 'sales_count', 'sold', 'total_sales'] as $name) {
                    if (Schema::hasColumn('products', $name)) {
                        $column = $name;
                        break;
                    }
                }
            }
        }

        return $column;
    }
}
