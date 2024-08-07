<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('superadmin', function () {
            return Auth::user()->role == 1;
        });
        Gate::define('admin', function () {
            return Auth::user()->role == 2;
        });
        Gate::define('user', function () {
            return Auth::user()->role == 3;
        });
    }
}
