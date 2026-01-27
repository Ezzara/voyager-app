<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        //fix string length database problem
        Schema::defaultStringLength(191);
        //forcing https on prod
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

    }
}
