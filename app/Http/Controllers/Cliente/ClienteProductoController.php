<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ClienteProductoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Cliente $cliente)
    {	
    	//dd($request->codigo);

    	//$productos = $cliente->citasmedicas->producto;

    	// $productos = $cliente->citasmedicas() 
    	// ->with('producto')  
    	// ->get()  
    	// ->pluck('producto'); 

    	$productos = $cliente->citasmedicas() 
                	->with('tratamientos.producto')  
                	->get()  
                	->pluck('tratamientos')
                	->collapse()
                	->pluck('producto') 
                	->unique('id')
                	->values();

    	return $this->showAll($productos);

    }

}
