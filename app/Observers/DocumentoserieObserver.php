<?php

namespace App\Observers;
 
use App\Models\Documentoserie;
use Illuminate\Support\Facades\Config;

class DocumentoserieObserver
{
    /**
     * Handle the documentoserie "created" event.
     *
     * @param  \App\Documentoserie  $documentoserie
     * @return void
     */
    public function created(Documentoserie $documentoserie)
    { 
        // dd('Hola');
        $idempresa = Config::get('constants.empresas.osi');          
        $idAuth = Config::get('constants.usuarios.andres'); 
        // $documentoserie->idempresa = $idempresa;
        $documentoserie->id_created_at = $idAuth; 
        $documentoserie->id_updated_at = $idAuth; 
    }

    public function creating(Documentoserie $documentoserie)
    {
        $idempresa = Config::get('constants.empresas.osi');          
        $idAuth = Config::get('constants.usuarios.andres'); 
        // $documentoserie->idempresa = $idempresa;
        $documentoserie->id_created_at = $idAuth; 
        $documentoserie->id_updated_at = $idAuth; 
    }

    public function saving(Documentoserie $documentoserie)
    { 

    }

    public function saved(Documentoserie $documentoserie)
    { 

    }

    /**
     * Handle the documentoserie "updated" event.
     *
     * @param  \App\Documentoserie  $documentoserie
     * @return void
     */
    public function updated(Documentoserie $documentoserie)
    {
        //
    }

    public function updating(Documentoserie $documentoserie)
    {
        $idAuth = Config::get('constants.usuarios.julio');   
        $documentoserie->id_updated_at = $idAuth; 
    }

    /**
     * Handle the documentoserie "deleted" event.
     *
     * @param  \App\Documentoserie  $documentoserie
     * @return void
     */
    public function deleted(Documentoserie $documentoserie)
    {
        //
    }

    public function deleting(Documentoserie $documentoserie)
    {
        $idAuth = Config::get('constants.usuarios.andres');           
        $documentoserie->id_deleted_at = $idAuth;
        $documentoserie->deleted = '1';
    }

    /**
     * Handle the documentoserie "restored" event.
     *
     * @param  \App\Documentoserie  $documentoserie
     * @return void
     */
    public function restored(Documentoserie $documentoserie)
    {        

    }

    public function restoring(Documentoserie $documentoserie)
    {        

    }

    /**
     * Handle the documentoserie "force deleted" event.
     *
     * @param  \App\Documentoserie  $documentoserie
     * @return void
     */
    public function forceDeleted(Documentoserie $documentoserie)
    {
        //
    }
}
