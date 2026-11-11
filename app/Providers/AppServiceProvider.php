<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\WebsiteSetting;
use App\Services\MobileDealFeed;
use App\View\Composers\SuperAdminHeaderComposer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('vendor-login', fn (Request $request) => Limit::perMinute(10)
            ->by(strtolower((string) $request->input('email')) . '|' . $request->ip()));
        RateLimiter::for('vendor-register', fn (Request $request) => Limit::perMinute(5)
            ->by('vendor-register|' . $request->ip()));
        RateLimiter::for('partner-login', fn (Request $request) => Limit::perMinute(10)
            ->by(strtolower((string) $request->input('email')) . '|' . $request->ip()));
        RateLimiter::for('partner-register', fn (Request $request) => Limit::perMinute(5)
            ->by('partner-register|' . $request->ip()));

        // Super admin shob permission/@can check e auto allowed
        Gate::before(function ($user, $ability) {
            return $user->hasRole(config('route_permissions.super_admin_role', 'superadmin')) ? true : null;
        });

        View::composer('*', function ($view) {
            static $settings = null;
            static $headerCategories = null;

            if ($settings === null) {
                $settings = WebsiteSetting::current();
            }

            if ($headerCategories === null) {
                $headerCategories = Cache::remember('header.categories', now()->addHours(6), function () {
                        return Category::whereNull('parent_id')
                            ->where('status', true)
                            ->with(['children' => function ($q) {
                                $q->where('status', true)
                                    ->with(['children' => function ($q2) {
                                        $q2->where('status', true);
                                    }]);
                            }])
                            ->orderBy('name')
                            ->get();
                    });
            }

            $view->with('siteSettings', $settings ?: null);

            // $site: kokhono null hoy na, policy/contact/static-area view gulo eta use kore
            $view->with('site', $settings ?: new WebsiteSetting());

            $view->with('headerCategories', $headerCategories);

        });

        // Cart queries are only needed by storefront layouts, never admin pages.
        View::composer('layouts.frontend.*', function ($view) {
            try {
                $view->with('cartCount', app(\App\Services\CartService::class)->getCartCount());
            } catch (\Throwable $e) {
                $view->with('cartCount', 0);
            }
        });

        // SuperAdmin header: pending alerts + latest orders
        View::composer('layouts.superadmin.header', SuperAdminHeaderComposer::class);

        // Mobile bottom nav : center Hot Deals product slider
        View::composer('layouts.frontend.mobile-bottom-nav', function ($view) {
            $deals = ['items' => [], 'has_more' => false];

            try {
                $deals = app(MobileDealFeed::class)->page(1);
            } catch (\Throwable $e) {
                // Keep the fallback Hot Deals button available if the feed is unavailable.
            }

            $view->with('navDeals', $deals);
        });
    }
}
