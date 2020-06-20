<?php

namespace App\Http\Controllers\Diagnostico;

use App\Models\Diagnostico;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DiagnosticoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Diagnostico());
              
        //\DB::enableQueryLog();
        $query = Diagnostico::with($resource)
            //->whereHas('citasmedicas') //aplica un sql de exits
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
     * @param  \App\Models\Diagnostico  $diagnostico
     * @return \Illuminate\Http\Response
     */
    public function show(Diagnostico $diagnostico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Diagnostico  $diagnostico
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnostico $diagnostico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diagnostico  $diagnostico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diagnostico $diagnostico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diagnostico  $diagnostico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnostico $diagnostico)
    {
        //
    }
}
