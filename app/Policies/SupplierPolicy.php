<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplier;

class SupplierPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, Supplier $supplier): bool
    {
        return $supplier->user_id === $user->id || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Supplier $supplier): bool
    {
        return $supplier->user_id === $user->id || $user->hasRole('superadmin');
    }

    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->hasRole('superadmin');
    }

    public function verify(User $user, Supplier $supplier): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }
}
