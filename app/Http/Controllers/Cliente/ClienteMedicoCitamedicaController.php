<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Sede;
use App\Models\Medico;
use App\Models\Cliente;
use App\Models\Citamedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Config;

class ClienteMedicoCitamedicaController extends ApiController
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cliente $cliente, Medico $medico)
    {   
        $reglas = [
            'sede_id' => 'required', 
            'referencia_id' => 'required',
            'reservacion_id' => 'required',
            'estadocita' => 'required|in:4,5,6,7',
            'estadopago' => 'required|in:71,72',
            'fecha' => 'required|date',
            'inicio' => 'required',
            'fin' => 'required',
            'tipo' => 'required|in:1,2,3',
            'costocero' => 'required|in:0,1'
        ]; 

        $campos = $this->validate($request, $reglas);
 
        if ($cliente->id === $medico->id) {
            return $this->errorResponse("El paciente debe ser diferente al médico", 409);
        }

        $sede = Sede::findOrFail($request['sede_id']); 
        if (!$sede) {
            return $this->errorResponse("Sede no existe", 404);
        }

        $campos = $request->all(); 
        $campos['empresa_id'] = Config::get('constants.empresas.osi');
        $campos['medico_id'] = $medico->id;
        $campos['paciente_id'] = $cliente->id;
        $campos['created_id'] = 1;
        $campos['updated_id'] = 1;
        //dd($campos);
        return DB::transaction(function () use ($campos, $cliente, $medico) { 
            //Algna accion. 
            //...

            $citamedica = Citamedica::create($campos);

            return $this->showOne($citamedica, 201);
        }); 
    }
 
}


