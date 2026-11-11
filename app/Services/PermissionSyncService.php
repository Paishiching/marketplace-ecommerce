<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class PermissionSyncService
{
    protected const CACHE_KEY = 'route_permissions.hash';

    public function superAdminRole(): string
    {
        return config('route_permissions.super_admin_role', 'superadmin');
    }

    public function guard(): string
    {
        return config('route_permissions.guard', 'web');
    }

    public function panels(): array
    {
        return config('route_permissions.panels', []);
    }

    /** Route name ke permission name e convert (store->create, update->edit) */
    public function canonical(string $name): string
    {
        foreach (config('route_permissions.aliases', []) as $from => $to) {
            if (Str::endsWith($name, '.' . $from)) {
                $alt = Str::beforeLast($name, '.') . '.' . $to;
                if (Route::has($alt)) {
                    return $alt;
                }
            }
        }

        return $name;
    }

    public function isAlwaysAllowed(string $name): bool
    {
        $patterns = config('route_permissions.always_allowed', []);

        return $patterns && Str::is($patterns, $name);
    }

    public function groupFor(string $name): string
    {
        $parts = array_slice(explode('.', $name), 1); // panel bad

        if (count($parts) === 1) {
            return $parts[0];
        }

        array_pop($parts); // action bad

        return implode('.', $parts);
    }

    /** Shob managed route er permission name */
    public function managedNames(): Collection
    {
        $prefixes = array_map(fn ($p) => $p . '.', $this->panels());
        $ignore   = config('route_permissions.ignore', []);

        return collect(array_keys(Route::getRoutes()->getRoutesByName()))
            ->filter(fn ($name) => $prefixes && Str::startsWith($name, $prefixes))
            ->reject(fn ($name) => $this->isAlwaysAllowed($name) || ($ignore && Str::is($ignore, $name)))
            ->map(fn ($name) => $this->canonical($name))
            ->unique()
            ->sort()
            ->values();
    }

    public function ensureSuperAdminRole(): Role
    {
        return Role::firstOrCreate([
            'name'       => $this->superAdminRole(),
            'guard_name' => $this->guard(),
        ]);
    }

    public function sync(bool $prune = false): array
    {
        $guard = $this->guard();
        $names = $this->managedNames();
        $created = $updated = $removed = 0;

        foreach ($names as $name) {
            $group = $this->groupFor($name);

            $permission = Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => $guard],
                ['group_name' => $group]
            );

            if ($permission->wasRecentlyCreated) {
                $created++;
            } elseif ($permission->group_name !== $group) {
                $permission->update(['group_name' => $group]);
                $updated++;
            }
        }

        if ($prune) {
            $removed = Permission::where('guard_name', $guard)
                ->where(function ($q) {
                    foreach ($this->panels() as $panel) {
                        $q->orWhere('name', 'like', $panel . '.%');
                    }
                })
                ->whereNotIn('name', $names->all())
                ->delete();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Cache::forever(self::CACHE_KEY, md5($names->implode('|')));

        return ['created' => $created, 'updated' => $updated, 'removed' => $removed, 'total' => $names->count()];
    }

    /** Route list change hole tobei sync kore (sosta check) */
    public function syncIfRoutesChanged(): void
    {
        $hash = md5($this->managedNames()->implode('|'));

        if (Cache::get(self::CACHE_KEY) !== $hash) {
            $this->sync();
        }
    }
}