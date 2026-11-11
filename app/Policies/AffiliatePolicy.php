<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Affiliate;

class AffiliatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, Affiliate $affiliate): bool
    {
        return $affiliate->user_id === $user->id || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Affiliate $affiliate): bool
    {
        return $affiliate->user_id === $user->id || $user->hasRole('superadmin');
    }

    public function delete(User $user, Affiliate $affiliate): bool
    {
        return $user->hasRole('superadmin');
    }
}
