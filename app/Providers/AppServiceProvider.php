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
    }
}
