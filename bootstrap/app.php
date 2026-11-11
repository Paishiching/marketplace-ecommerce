<?php

use App\Http\Middleware\EnsureRoutePermission;
use App\Http\Middleware\EnsurePartnerApproved;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Role-wise route file gulo ekhane ekbar-i register hobe
            Route::middleware('web')->group(base_path('routes/superadmin.php'));
            Route::middleware('web')->group(base_path('routes/admin.php'));
            Route::middleware('web')->group(base_path('routes/vendor.php'));
            Route::middleware('web')->group(base_path('routes/supplier.php'));
            Route::middleware('web')->group(base_path('routes/affiliate.php'));
            Route::middleware('web')->group(base_path('routes/reseller.php'));
            Route::middleware('web')->group(base_path('routes/dropshipping.php'));
            Route::middleware('web')->group(base_path('routes/wholesale.php'));
            Route::middleware('web')->group(base_path('routes/customer.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'               => RoleMiddleware::class,
            'permission'         => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'route.permission'   => EnsureRoutePermission::class,
            'partner.approved'   => EnsurePartnerApproved::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $exception, \Illuminate\Http\Request $request) {
            if ($exception->getStatusCode() === 403 && ! $request->expectsJson()) {
                return response()->view('errors.403', [], 403);
            }
        });
    })->create();
