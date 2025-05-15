<?php

// use Illuminate\Foundation\Application;
// use Illuminate\Foundation\Configuration\Exceptions;
// use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Support\Facades\Route;
// use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
// use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         using: function () {
//             $centralDomains = config('tenancy.central_domains');

//             // Register central domain routes
//             foreach ($centralDomains as $domain) {
//                 Route::middleware('web')
//                     ->domain($domain)
//                     ->group(base_path('routes/web.php'));
//             }
//             // Route::middleware('web')->group(base_path('routes/tenant.php'));
//             Route::middleware('web')->group(base_path('routes/tenant/tenant.php'));
//             Route::middleware('web')->group(base_path('routes/tenant/admin.php'));
//             Route::middleware('web')->group(base_path('routes/tenant/teacher.php'));
//             Route::middleware('web')->group(base_path('routes/tenant/parent.php'));
//             Route::middleware('web')->group(base_path('routes/tenant/student.php'));
//         },
//         web: __DIR__ . '/../routes/web.php',
//         commands: __DIR__ . '/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         $middleware->alias([
//             'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
//             'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
//             'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
//         ]);
//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     })->create();


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();