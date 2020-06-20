<?php

namespace App\Http\Controllers\Referencia;

use App\Models\Referencia;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ReferenciaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Referencia());
         
        //\DB::enableQueryLog();
        $query = Referencia::with($resource)
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
     * @param  \App\Models\Referencia  $referencia
     * @return \Illuminate\Http\Response
     */
    public function show(Referencia $referencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Referencia  $referencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Referencia $referencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referencia  $referencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referencia $referencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Referencia  $referencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referencia $referencia)
    {
        //
    }
}
