<?php

namespace App\Http\Controllers\Modulo;

use App\Models\Modulo;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ModuloController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Modulo());
          
        //\DB::enableQueryLog();
        $query = Modulo::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            
 
            if ($pageSize)
                $data = $query->paginate($pageSize); 
            else
                $data = $query->get();

        //dd(\DB::getQueryLog());
        //dd($data);
        return $this->showPaginateAll($data);
    }

    public function modulosEmpresa()
    {
        $empresa = Empresa::findOrfail(auth()->user()->idempresa);

        $data = $empresa->modulos;
        
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
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show(Modulo $modulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulo $modulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modulo $modulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo)
    {
        //
    }
}
