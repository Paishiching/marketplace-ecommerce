<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Commission;
use Illuminate\Support\Carbon;

class ReportService
{
    /**
     * Total sales, order count, and average order value between two dates.
     */
    public function salesSummary(Carbon $from, Carbon $to): array
    {
        $orders = Order::whereBetween('created_at', [$from, $to])
            ->where('status', '!=', 'cancelled')
            ->get();

        $totalSales = $orders->sum('total');
        $orderCount = $orders->count();

        return [
            'total_sales' => round($totalSales, 2),
            'order_count' => $orderCount,
            'average_order_value' => $orderCount > 0 ? round($totalSales / $orderCount, 2) : 0,
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
        ];
    }

    /**
     * Best-selling products by quantity sold in a date range.
     */
    public function topProducts(Carbon $from, Carbon $to, int $limit = 10)
    {
        return OrderItem::whereHas('order', function ($query) use ($from, $to) {
            $query->whereBetween('created_at', [$from, $to])
                ->where('status', '!=', 'cancelled');
        })
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(total) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->with('product')
            ->get();
    }

    /**
     * Per-vendor sales and commission totals for a date range.
     */
    public function vendorPerformance(Carbon $from, Carbon $to)
    {
        return OrderItem::whereHas('order', function ($query) use ($from, $to) {
            $query->whereBetween('created_at', [$from, $to])
                ->where('status', '!=', 'cancelled');
        })
            ->selectRaw('vendor_id, SUM(total) as total_sales, COUNT(DISTINCT order_id) as order_count')
            ->groupBy('vendor_id')
            ->with('vendor')
            ->get();
    }

    /**
     * Total commission earned by the platform in a date range.
     */
    public function commissionSummary(Carbon $from, Carbon $to): array
    {
        $commissions = Commission::whereBetween('created_at', [$from, $to])->get();

        return [
            'total_commission' => round($commissions->sum('amount'), 2),
            'count' => $commissions->count(),
        ];
    }
}
