<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function view(User $user, User $target): bool
    {
        return $user->id === $target->id || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id || $user->hasRole('superadmin');
    }

    public function delete(User $user, User $target): bool
    {
        return $user->hasRole('superadmin') && $user->id !== $target->id;
    }
}
