<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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
        App::setLocale(config('app.locale'));

        // Seta o locale no PHP para traduções via strftime (caso use)
        setlocale(LC_TIME, config('app.locale'));

        // Seta o locale do Carbon globalmente
        Carbon::setLocale(config('app.locale'));
    }
}
