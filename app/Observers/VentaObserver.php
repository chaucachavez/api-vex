<?php

namespace App\Observers;
 
use App\Models\Venta;
use Illuminate\Support\Facades\Config;

class VentaObserver
{
    /**
     * Handle the venta "created" event.
     *
     * @param  \App\Venta  $venta
     * @return void
     */
    public function created(Venta $venta)
    {
        $idempresa = Config::get('constants.empresas.osi');          
        $idAuth = Config::get('constants.usuarios.andres'); 
        $venta->idempresa = $idempresa;
        $venta->id_created_at = $idAuth; 
        $venta->id_updated_at = $idAuth; 
    }

    /**
     * Handle the venta "updated" event.
     *
     * @param  \App\Venta  $venta
     * @return void
     */
    public function updated(Venta $venta)
    {
        //
    }

    public function updating(Venta $venta)
    { 
        $idAuth = Config::get('constants.usuarios.julio');   
        $venta->id_updated_at = $idAuth; 

    }
    /**
     * Handle the venta "deleted" event.
     *
     * @param  \App\Venta  $venta
     * @return void
     */
    public function deleted(Venta $venta)
    {
        //
    }

    public function deleting(Venta $venta)
    {   
        $idAuth = Config::get('constants.usuarios.andres');   
        $venta->id_deleted_at = $idAuth;
        $venta->deleted = '1';
    }

    /**
     * Handle the venta "restored" event.
     *
     * @param  \App\Venta  $venta
     * @return void
     */
    public function restored(Venta $venta)
    {
        //
    }

    /**
     * Handle the venta "force deleted" event.
     *
     * @param  \App\Venta  $venta
     * @return void
     */
    public function forceDeleted(Venta $venta)
    {
        //
    }
}
