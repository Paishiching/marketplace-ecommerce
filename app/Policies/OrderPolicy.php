<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Order $order): bool
    {
        if ($order->customer && $order->customer->user_id === $user->id) {
            return true;
        }

        if ($order->vendorOrders()->whereHas('vendor', fn ($q) => $q->where('user_id', $user->id))->exists()) {
            return true;
        }

        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Order $order): bool
    {
        return $user->hasRole('admin')
            || $user->hasRole('superadmin')
            || $order->vendorOrders()->whereHas('vendor', fn ($q) => $q->where('user_id', $user->id))->exists();
    }

    public function cancel(User $user, Order $order): bool
    {
        return ($order->customer && $order->customer->user_id === $user->id && $order->status === 'pending')
            || $user->hasRole('admin')
            || $user->hasRole('superadmin');
    }
}
