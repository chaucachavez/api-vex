<?php

namespace App\Http\Controllers\Ventadet;

use App\Models\Ventadet;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class VentadetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Ventadet());
          
        //\DB::enableQueryLog();
        $query = Ventadet::with($resource)
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
     * @param  \App\Models\Ventadet  $ventadet
     * @return \Illuminate\Http\Response
     */
    public function show(Ventadet $ventadetalle)
    {
        //dd($ventadet);
        return $this->showOne($ventadetalle); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ventadet  $ventadet
     * @return \Illuminate\Http\Response
     */
    public function edit(Ventadet $ventadet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ventadet  $ventadet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ventadet $ventadet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ventadet  $ventadet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ventadet $ventadet)
    {
        //
    }
}
