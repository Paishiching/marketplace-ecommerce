<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payment;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, Payment $payment): bool
    {
        if ($payment->order && $payment->order->customer && $payment->order->customer->user_id === $user->id) {
            return true;
        }

        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function refund(User $user, Payment $payment): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }
}
