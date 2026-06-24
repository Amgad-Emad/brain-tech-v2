<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        // On an HTTPS host (e.g. shared hosting), generate https:// asset URLs so
        // the compiled CSS/JS aren't blocked as mixed content.
        if (! $this->app->runningUnitTests() && Str::startsWith((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
