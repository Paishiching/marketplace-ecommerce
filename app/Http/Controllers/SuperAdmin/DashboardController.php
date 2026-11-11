<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingZone;
use App\Models\Vendor;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /** Ei mash-er order target (Sales Target card). Chaile ekhane change koro. */
    private const MONTHLY_ORDER_TARGET = 1000;

    /** Revenue theke ei status gulo bad jabe. */
    private const EXCLUDED_STATUSES = ['cancelled', 'returned'];

    public function index()
    {
        $data = Cache::remember('superadmin.dashboard.payload.v1', now()->addSeconds(60), fn () => $this->dashboardData());

        return view('superadmin.dashboard.index', $data);
    }

    private function dashboardData(): array
    {
        $currency = '৳';

        // ---------------------------------------------------------------
        // Top cards
        // ---------------------------------------------------------------
        $stats = [
            'orders'     => Order::count(),
            'revenue'    => (float) Order::whereNotIn('status', self::EXCLUDED_STATUSES)->sum('total'),
            'customers'  => Customer::count(),
            'vendors'    => Vendor::where('status', 'approved')->count(),
            'products'   => Product::count(),
            'categories' => Category::count(),
        ];

        // ---------------------------------------------------------------
        // Chart data
        // ---------------------------------------------------------------
        $week    = $this->dailySeries(7);
        $month30 = $this->dailySeries(30);
        $monthly = $this->monthlySeries(12);

        $thisMonthRevenue = end($monthly['revenue']);
        $lastMonthRevenue = $monthly['revenue'][count($monthly['revenue']) - 2] ?? 0;
        $ordersThisMonth  = end($monthly['orders']);

        $revenueChange = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : null;

        $target    = self::MONTHLY_ORDER_TARGET;
        $targetPct = min(100, (int) round(($ordersThisMonth / max($target, 1)) * 100));

        $statusCounts = Order::select('status', DB::raw('COUNT(*) as c'))
            ->groupBy('status')
            ->pluck('c', 'status')
            ->all();

        // Top shipping zones (Top Sales Locations)
        $zoneRows = Order::whereNotNull('shipping_zone_id')
            ->select('shipping_zone_id', DB::raw('COUNT(*) as c'))
            ->groupBy('shipping_zone_id')
            ->orderByDesc('c')
            ->limit(5)
            ->get();

        $zoneModels = ShippingZone::whereIn('id', $zoneRows->pluck('shipping_zone_id'))->get()->keyBy('id');

        $topZones = $zoneRows->map(function ($row) use ($zoneModels) {
            $zone = $zoneModels->get($row->shipping_zone_id);

            return (object) [
                'name'  => $zone->name ?? ('Zone #' . $row->shipping_zone_id),
                'count' => (int) $row->c,
            ];
        });

        $chart = [
            'sparkLabels'    => $week['labels'],
            'sparkOrders'    => $week['orders'],
            'sparkRevenue'   => $week['revenue'],
            'sparkCustomers' => $this->dailyCounts(Customer::class, 7),
            'sparkVendors'   => $this->dailyCounts(Vendor::class, 7),
            'monthly'        => $monthly,
            'daily30'        => $month30,
            'status'         => $statusCounts,
            'zones'          => [
                'names'  => $topZones->pluck('name')->values(),
                'counts' => $topZones->pluck('count')->values(),
            ],
            'target'         => ['percent' => $targetPct],
        ];

        // ---------------------------------------------------------------
        // Lists
        // ---------------------------------------------------------------
        $newCustomers = Customer::with('user')->latest()->limit(10)->get();

        $topRows = OrderItem::select(
                'order_items.product_id',
                DB::raw('SUM(order_items.quantity) as sold'),
                DB::raw('SUM(order_items.total_price) as revenue')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereNull('orders.deleted_at')
            ->whereNotIn('orders.status', self::EXCLUDED_STATUSES)
            ->groupBy('order_items.product_id')
            ->orderByDesc('sold')
            ->limit(10)
            ->get();

        $topProductModels = Product::with('primaryImage')
            ->whereIn('id', $topRows->pluck('product_id'))
            ->get()
            ->keyBy('id');

        $topProducts = $topRows
            ->map(fn ($row) => (object) [
                'product' => $topProductModels->get($row->product_id),
                'sold'    => (int) $row->sold,
                'revenue' => (float) $row->revenue,
            ])
            ->filter(fn ($row) => $row->product);

        $topVendors = Vendor::withCount(['products', 'vendorOrders'])
            ->withSum('orderItems as earnings', 'total_price')
            ->orderByDesc('earnings')
            ->limit(5)
            ->get();

        $pendingWithdrawals = Withdrawal::with('withdrawable')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $recentOrders = Order::with(['orderItems.product.primaryImage', 'orderItems.vendor'])
            ->latest()
            ->limit(7)
            ->get();

        return compact(
            'currency',
            'stats',
            'chart',
            'thisMonthRevenue',
            'revenueChange',
            'ordersThisMonth',
            'target',
            'targetPct',
            'topZones',
            'newCustomers',
            'topProducts',
            'topVendors',
            'pendingWithdrawals',
            'recentOrders'
        );
    }

    /**
     * Last $days din-er order count + revenue (din onujayi, faka din e 0).
     */
    private function dailySeries(int $days): array
    {
        $start = now()->subDays($days - 1)->startOfDay();

        $rows = Order::where('created_at', '>=', $start)
            ->selectRaw("DATE(created_at) as d, COUNT(*) as orders, SUM(CASE WHEN status NOT IN ('cancelled','returned') THEN total ELSE 0 END) as revenue")
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $labels = [];
        $orders = [];
        $revenue = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $row  = $rows->get($date->toDateString());

            $labels[]  = $date->format('d M');
            $orders[]  = (int) ($row->orders ?? 0);
            $revenue[] = round((float) ($row->revenue ?? 0), 2);
        }

        return compact('labels', 'orders', 'revenue');
    }

    /**
     * Last $months mash-er order count + revenue.
     */
    private function monthlySeries(int $months): array
    {
        $start = now()->startOfMonth()->subMonths($months - 1);

        $rows = Order::where('created_at', '>=', $start)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as orders, SUM(CASE WHEN status NOT IN ('cancelled','returned') THEN total ELSE 0 END) as revenue")
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $labels = [];
        $orders = [];
        $revenue = [];

        for ($i = 0; $i < $months; $i++) {
            $date = $start->copy()->addMonths($i);
            $row  = $rows->get($date->format('Y-m'));

            $labels[]  = $date->format('M y');
            $orders[]  = (int) ($row->orders ?? 0);
            $revenue[] = round((float) ($row->revenue ?? 0), 2);
        }

        return compact('labels', 'orders', 'revenue');
    }

    /**
     * Kono model-er last $days din-er new record count (sparkline-er jonno).
     */
    private function dailyCounts(string $model, int $days): array
    {
        $start = now()->subDays($days - 1)->startOfDay();

        $rows = $model::where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');

        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $data[] = (int) ($rows[$start->copy()->addDays($i)->toDateString()] ?? 0);
        }

        return $data;
    }
}
