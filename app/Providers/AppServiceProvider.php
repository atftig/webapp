<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\BarcodeScanner;
use URL;

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
        // Registra il componente personalizzato
        Blade::component('barcode-scanner', BarcodeScanner::class);
        if(str_contains(config('app.url'), 'https')){
            URL::forceScheme('https');
        }
    }
}
