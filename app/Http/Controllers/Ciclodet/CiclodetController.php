<?php

namespace App\Http\Controllers\Ciclodet;

use App\Models\Ciclodet;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CiclodetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Ciclodet());
      
        //\DB::enableQueryLog();
        $query = Ciclodet::with($resource)
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
     * @param  \App\Models\Ciclodet  $ciclodet
     * @return \Illuminate\Http\Response
     */
    public function show(Ciclodet $ciclodet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ciclodet  $ciclodet
     * @return \Illuminate\Http\Response
     */
    public function edit(Ciclodet $ciclodet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ciclodet  $ciclodet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ciclodet $ciclodet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ciclodet  $ciclodet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ciclodet $ciclodet)
    {
        //
    }
}
