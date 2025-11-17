<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\EnsureProjectAccess;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register project middleware alias so routes can use ->middleware('project')
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('project', EnsureProjectAccess::class);
        }

        // Ensure AdminLTE view namespace is available when package views are published
        // Some composer operations may remove the original package provider; map the
        // published views to the `adminlte` namespace so blade calls like
        // `adminlte::page` continue to work.
        $adminltePath = resource_path('views/vendor/adminlte');
        if (is_dir($adminltePath)) {
            $this->loadViewsFrom($adminltePath, 'adminlte');
        }
    }
}
