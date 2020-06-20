<?php

namespace App\Http\Controllers\Unidad;

use App\Models\Unidad;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UnidadController extends ApiController
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
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Unidad());
         
        //\DB::enableQueryLog();
        $query = Unidad::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($pageSize)
                $data = $query->paginate($pageSize);
            else
                $data = $query->get();

        if ($pageSize)
            $data = $query->paginate($pageSize);
        else
            $data = $query->get();

        //dd(\DB::getQueryLog());
        //dd($data);
        return $this->showPaginateAll($data);
    }

    public function unidadesEmpresa()
    {
        $data = Unidad::select('unidad.codigo', 'unidad.nombre')
                            ->join('unidadempresa', 'unidad.codigo', '=', 'unidadempresa.codigo')
                            ->where('idempresa', auth()->user()->idempresa)
                            ->get();

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
     * @param  \App\Models\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function show(Unidad $unidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidad $unidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidad $unidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidad $unidad)
    {
        //
    }
}
