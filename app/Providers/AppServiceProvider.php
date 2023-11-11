<?php

namespace App\Providers;

use App\Models\Configuracion;
use App\Repositories\AdminCursadaRepository;
use App\Services\AlumnoInscripcionService;
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
        $this->app->bind(AdminCursadaRepository::class);
        $this->app->bind(AlumnoInscripcionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('textFormatService', new TextFormatService());
        View::share('formatoFecha', new Fecha());
        View::share('config', Configuracion::todas());
    }
}
