<?php

namespace App\Observers;

use App\Models\Sede;
use Illuminate\Support\Facades\Config;

class SedeObserver
{
    /**
     * Handle the sede "created" event.
     *
     * @param  \App\Sede  $sede
     * @return void
     */
    public function created(Sede $sede)
    {
        //
    }

    public function creating(Sede $sede)
    {
        $idempresa = Config::get('constants.empresas.osi');  
        // $sede->idempresa = $idempresa; 
    }

    /**
     * Handle the sede "updated" event.
     *
     * @param  \App\Sede  $sede
     * @return void
     */
    public function updated(Sede $sede)
    {
        
    }

    /**
     * Handle the sede "deleted" event.
     *
     * @param  \App\Sede  $sede
     * @return void
     */
    public function deleted(Sede $sede)
    {
        //
    }

    /**
     * Handle the sede "restored" event.
     *
     * @param  \App\Sede  $sede
     * @return void
     */
    public function restored(Sede $sede)
    {
        //
    }

    /**
     * Handle the sede "force deleted" event.
     *
     * @param  \App\Sede  $sede
     * @return void
     */
    public function forceDeleted(Sede $sede)
    {
        //
    }
}
