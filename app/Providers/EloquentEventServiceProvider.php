<?php

namespace App\Providers;

use App\Models\Sede; 
use App\Models\Documentoserie;
use App\Observers\SedeObserver; 
use Illuminate\Support\ServiceProvider;
use App\Observers\DocumentoserieObserver;

class EloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Ifact.pe
        Documentoserie::observe(DocumentoserieObserver::class);
        Sede::observe(SedeObserver::class); 
    }
}
