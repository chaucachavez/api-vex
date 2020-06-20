<?php

namespace App\Http\Controllers\Ubigeo;

use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class UbigeoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Ubigeo());
            
        //\DB::enableQueryLog();
        $query = Ubigeo::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            
 
            if ($pageSize)
                $data =  $query->paginate($pageSize);
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
     * @param  \App\Models\Ubigeo  $ubigeo
     * @return \Illuminate\Http\Response
     */
    public function show(Ubigeo $ubigeo)
    {     
        return $this->showOne($ubigeo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ubigeo  $ubigeo
     * @return \Illuminate\Http\Response
     */
    public function edit(Ubigeo $ubigeo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ubigeo  $ubigeo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ubigeo $ubigeo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ubigeo  $ubigeo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ubigeo $ubigeo)
    {
        //
    }

    public function departamentos(Request $request, $pais) 
    {           
        Ubigeo::where('pais', '=', $pais)
                ->where('dpto', '=', '000')
                ->where('prov', '=', '00')
                ->where('dist', '=', '00')
                ->firstOrFail(); 

        // DB::enableQueryLog();
        $data = Ubigeo::select('idubigeo', 'nombre')
                ->where('pais', '=', $pais)
                ->where('dpto', '!=', '000')
                ->where('prov', '=', '00')
                ->where('dist', '=', '00')
                ->orderBy('nombre', 'asc')
                ->get();
        // dd(DB::getQueryLog());

        return $this->showPaginateAll($data);
    }

    public function provincias(Request $request, $pais, $departamento) 
    {           
        Ubigeo::where('pais', '=', $pais)
                ->where('dpto', '=', $departamento)
                ->where('prov', '=', '00')
                ->where('dist', '=', '00')
                ->firstOrFail(); 
        // DB::enableQueryLog();
        $data = Ubigeo::select('idubigeo', 'nombre')
                ->where('pais', '=', $pais)
                ->where('dpto', '=', $departamento)
                ->where('prov', '!=', '00')
                ->where('dist', '=', '00')
                ->orderBy('nombre', 'asc')
                ->get();
        // dd(DB::getQueryLog());

        return $this->showPaginateAll($data);
    }

    public function distritos(Request $request, $pais, $departamento, $provincia) 
    {           
        Ubigeo::where('pais', '=', $pais)
                ->where('dpto', '=', $departamento)
                ->where('prov', '=', $provincia)
                ->where('dist', '=', '00') 
                ->firstOrFail(); 
         
        $data = Ubigeo::select('idubigeo', 'nombre')
                ->where('pais', '=', $pais)
                ->where('dpto', '=', $departamento)
                ->where('prov', '=', $provincia)
                ->where('dist', '!=', '00') 
                ->orderBy('nombre', 'asc')
                ->get(); 

        return $this->showPaginateAll($data);
    }



}
