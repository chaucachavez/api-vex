<?php

namespace App\Http\Controllers\Categoria;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoriaProductoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Categoria $categoria)
    {
        
        $categorias = $categoria->productos;

        return $this->ShowAll($categorias);
    }
}
