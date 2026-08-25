<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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

        // A Livewire szkriptje alapból render-blokkoló <script> tagként
        // töltődik be (a Vite-tal ellentétben, ami type="module"-ként
        // eleve halasztott). A defer csak a VÉGREHAJTÁST tolja a DOM
        // feldolgozása utánra — ez nem CSS, nem befolyásolja az
        // elrendezést, tehát biztonságos (nem az a hiba, ami a
        // stíluslap-halasztásnál CLS-ugrást okozott).
        Livewire::useScriptTagAttributes([
            'defer' => true,
        ]);
    }
}
