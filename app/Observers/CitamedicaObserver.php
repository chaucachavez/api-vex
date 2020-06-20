<?php

namespace App\Observers;

use App\Models\Citamedica;
 

class CitamedicaObserver
{
    /**
     * Handle the citamedica "created" event.
     *
     * @param  \App\Citamedica  $citamedica
     * @return void
     */
    public function created(Citamedica $citamedica)
    {
        //
    }

    /**
     * Handle the citamedica "updated" event.
     *
     * @param  \App\Citamedica  $citamedica
     * @return void
     */
    public function updated(Citamedica $citamedica)
    {
        //
    }

    /**
     * Handle the citamedica "deleted" event.
     *
     * @param  \App\Citamedica  $citamedica
     * @return void
     */
    public function deleted(Citamedica $citamedica)
    {
        //
    }

    /**
     * Handle the citamedica "restored" event.
     *
     * @param  \App\Citamedica  $citamedica
     * @return void
     */
    public function restored(Citamedica $citamedica)
    {
        //
    }

    /**
     * Handle the citamedica "force deleted" event.
     *
     * @param  \App\Citamedica  $citamedica
     * @return void
     */
    public function forceDeleted(Citamedica $citamedica)
    {
        //
    }
}
