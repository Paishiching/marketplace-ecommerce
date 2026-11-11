<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected static function booted(): void
    {
        // Purono table e slug column thakle auto fill
        static::saving(function (self $role) {
            if (empty($role->slug) && Schema::hasColumn($role->getTable(), 'slug')) {
                $role->slug = Str::slug($role->name);
            }
        });
    }
}