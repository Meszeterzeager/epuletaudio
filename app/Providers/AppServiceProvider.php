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
        // TLS-t lezáró proxy (pl. Cloudflare Tunnel) mögött a beérkező kérés
        // maga HTTP, de a böngésző felől HTTPS-ként töltődött be — generált
        // URL-eket (asset, route) ehhez igazítjuk, hogy ne legyen mixed content.
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
