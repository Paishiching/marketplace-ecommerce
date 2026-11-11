<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $canProducts = $user->can('admin.products.products.index');
        $canCategories = $user->can('admin.products.categories.index');
        $canOrders = $user->can('admin.orders.orders.index');

        $stats = [
            'products' => $canProducts ? Product::count() : null,
            'categories' => $canCategories ? Category::count() : null,
            'orders' => $canOrders ? Order::count() : null,
        ];

        $actions = [];
        if ($user->can('admin.products.products.create')) {
            $actions[] = ['label' => 'Add product', 'description' => 'Create a product listing for review.', 'route' => 'admin.products.products.create', 'icon' => 'bx-package'];
        }
        if ($user->can('admin.products.categories.create')) {
            $actions[] = ['label' => 'Add category', 'description' => 'Organize the catalog into useful groups.', 'route' => 'admin.products.categories.create', 'icon' => 'bx-category'];
        }
        if ($user->can('admin.orders.orders.create')) {
            $actions[] = ['label' => 'New order', 'description' => 'Enter an order for a customer.', 'route' => 'admin.orders.orders.create', 'icon' => 'bx-receipt'];
        }

        return view('admin.dashboard.index', compact('stats', 'actions'));
    }
}
