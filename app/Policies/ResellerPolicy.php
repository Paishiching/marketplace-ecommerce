<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reseller;

class ResellerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, Reseller $reseller): bool
    {
        return $reseller->user_id === $user->id || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Reseller $reseller): bool
    {
        return $reseller->user_id === $user->id || $user->hasRole('superadmin');
    }

    public function delete(User $user, Reseller $reseller): bool
    {
        return $user->hasRole('superadmin');
    }
}
