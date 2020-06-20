<?php

namespace App\Http\Controllers\Producto;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductoCategoriaController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Producto $producto)
    {
        $categorias = $producto->categorias->paginate(15);
        
        dd($categorias);

        return $this->showAll($categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto, Categoria $categoria)
    {
        //sync, attach, syncWithoutDetaching
        $producto->categorias()->syncWithoutDetaching([$categoria->id]);

        return $this->showAll($producto->categorias);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto, Categoria $categoria)
    {
        if (!$producto->categorias()->find($categoria->id)) {
            return $this->errorResponse("La categoria especificada no es una categoria de este producto", 404);
        }

        $producto->categorias()->detach([$categoria->id]);

        return $this->ShowAll($producto->categorias);
    }
}
