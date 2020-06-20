<?php

namespace App\Http\Controllers\Consultorio;

use App\Models\Consultorio;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ConsultorioController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Consultorio());
             
        //\DB::enableQueryLog();
        $query = Consultorio::with($resource)
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
     * @param  \App\Models\Consultorio  $consultorio
     * @return \Illuminate\Http\Response
     */
    public function show(Consultorio $consultorio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultorio  $consultorio
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultorio $consultorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultorio  $consultorio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultorio $consultorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultorio  $consultorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultorio $consultorio)
    {
        //
    }
}
