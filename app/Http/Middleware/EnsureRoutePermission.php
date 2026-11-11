<?php

namespace App\Http\Middleware;

use App\Services\PermissionSyncService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoutePermission
{
    public function __construct(protected PermissionSyncService $sync)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Super admin shob jaygay allowed
        if ($user->hasRole($this->sync->superAdminRole())) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        // Name chara route ba unmanaged panel e non-super der dhukte dewa hobe na
        if (! $routeName) {
            abort(403);
        }

        $panel = Str::before($routeName, '.');

        if (! in_array($panel, $this->sync->panels(), true)) {
            abort(403);
        }

        if ($panel === 'admin' && ! $user->hasRole('admin')) {
            abort(403, 'This area is only available to administrator accounts.');
        }

        if ($this->sync->isAlwaysAllowed($routeName)) {
            return $next($request);
        }

        if ($user->can($this->sync->canonical($routeName))) {
            return $next($request);
        }

        abort(403, 'You do not have permission to perform this action.');
    }
}
