<?php

namespace App\Providers;

use App\Contracts\TmdbApiInterface;
use App\Services\TmdbApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TmdbApiInterface::class, function ($app) {
            return new TmdbApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
