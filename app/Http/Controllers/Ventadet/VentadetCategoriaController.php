<?php

namespace App\Http\Controllers\Ventadet;

use App\Models\Ventadet;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class VentadetCategoriaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Ventadet $ventadetalle)
    {
        $categorias = $ventadetalle->producto->categorias;

        return $this->showAll($categorias);
    }
 
}
