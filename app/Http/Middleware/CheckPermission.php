<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Usage in routes: ->middleware('permission:products.manage')
 * Expects the authenticated user to have a permissions() relation
 * (e.g. via roles->permissions) exposing permission slugs.
 */
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        $hasPermission = method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : optional($user->role)->permissions?->pluck('slug')->contains($permission);

        if (! $hasPermission) {
            throw new AccessDeniedHttpException('You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
