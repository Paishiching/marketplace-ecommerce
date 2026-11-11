<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;

class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $vendor->user_id === $user->id || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $vendor->user_id === $user->id || $user->hasRole('superadmin');
    }

    public function delete(User $user, Vendor $vendor): bool
    {
        return $user->hasRole('superadmin');
    }

    public function approve(User $user, Vendor $vendor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }
}
