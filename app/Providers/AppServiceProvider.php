<?php

namespace App\Providers;

use App\Services\Fecha;
use App\Services\TextFormatService;
use Illuminate\Support\Facades\View;
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
        View::share('textFormatService', new TextFormatService());
        View::share('formatoFecha', new Fecha());
    }
}
