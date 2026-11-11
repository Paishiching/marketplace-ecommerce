<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;

class WithdrawalPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Withdrawal $withdrawal): bool
    {
        return $withdrawal->user_id === $user->id || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('vendor')
            || $user->hasRole('supplier')
            || $user->hasRole('affiliate')
            || $user->hasRole('reseller');
    }

    public function approve(User $user, Withdrawal $withdrawal): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function cancel(User $user, Withdrawal $withdrawal): bool
    {
        return ($withdrawal->user_id === $user->id && $withdrawal->status === 'pending')
            || $user->hasRole('superadmin');
    }
}
