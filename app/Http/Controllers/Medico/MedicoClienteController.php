<?php

namespace App\Http\Controllers\Medico;

use App\Models\Medico;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class MedicoClienteController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Medico $medico)
    {
        dd('jc');
        $clientes = $medico->citasmedicas()
        ->with('cliente')
        ->get()
        ->pluck('cliente')
        ->unique('id')
        ->values();
        
        dd($clientes);
        return $this->showAll($clientes);
    }

}
