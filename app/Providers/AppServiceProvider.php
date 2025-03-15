<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TwitchService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // registro twitch service
        $this->app->singleton(TwitchService::class, function ($app) {
            return new TwitchService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
