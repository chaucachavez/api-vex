<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class ClienteCitamedicaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cliente $cliente)
    {   

        //DB::enableQueryLog();
        $citasmedicas = $cliente->citasmedicas;
        //dd(DB::getQueryLog());
        

        return $citasmedicas;
    }

}
