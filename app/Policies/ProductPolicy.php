<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('vendor') || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function update(User $user, Product $product): bool
    {
        return $this->owns($user, $product) || $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->owns($user, $product) || $user->hasRole('superadmin');
    }

    protected function owns(User $user, Product $product): bool
    {
        return $product->vendor && $product->vendor->user_id === $user->id;
    }
}
