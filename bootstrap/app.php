<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
            Route::middleware('web')
                ->prefix('vendor')
                ->name('vendor.')
                ->group(base_path('routes/vendor.php'));

            foreach (['admin', 'dealer', 'accounts', 'user'] as $role) {
                Route::middleware(['web', 'auth', "role:$role"])
                    ->prefix($role)
                    ->name("$role.")
                    ->group(base_path('routes/panel.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
            'role' => RoleMiddleware::class,
            'auth' => Authenticate::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
