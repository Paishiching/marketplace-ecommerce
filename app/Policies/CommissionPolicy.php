<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Commission;

class CommissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, Commission $commission): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Commission $commission): bool
    {
        return $user->hasRole('superadmin');
    }
}
