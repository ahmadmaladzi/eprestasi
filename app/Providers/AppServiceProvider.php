<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Di hosting (HTTPS) paksa semua URL aset/CSS/JS pakai https
        // supaya tidak diblokir browser (mixed content) dan tampilan tidak acak-acakan.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}