<?php

namespace App\Http\Controllers\Catalogo;

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CatalogoController extends ApiController
{   
    public function __construct()
    {   
        $this->middleware('jwt'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validaciones con Request
        // $reglas = [
        //     // 'likeNombre' => 'required'
        // ];
        // $this->validate($request, $reglas);

        if (!$request->filled('likeNombre') && !$request->filled('likeCodigo')) {
            return $this->errorResponse("Especifique un parámetro de búsqueda", 422);
        }

        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Catalogo());
        
        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL;
        $likeCodigo = request()->filled(['likeCodigo']) ? request()->input('likeCodigo') : NULL; 

        //\DB::enableQueryLog();
        $query = Catalogo::with($resource)
                ->where($where)
                ->orderBy($orderName, $orderSort);

        if ($likeNombre) 
            $query->where('nombre', 'LIKE', '%'. $likeNombre .'%');

        if ($likeCodigo) 
            $query->where('codigo', 'LIKE', '%'. $likeCodigo .'%');
        
        
        if (is_null($pageSize)) { //No mostrar los MILLONES! de regostros
            $pageSize = 25;
        }

        if ($pageSize)
            $data = $query->paginate($pageSize);
        else
            $data = $query->get();
        //dd(\DB::getQueryLog());

        //dd($data);
        return $this->showPaginateAll($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalogo  $catalogo
     * @return \Illuminate\Http\Response
     */
    public function show(Catalogo $catalogo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catalogo  $catalogo
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalogo $catalogo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalogo  $catalogo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalogo $catalogo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalogo  $catalogo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalogo $catalogo)
    {
        //
    }
}
