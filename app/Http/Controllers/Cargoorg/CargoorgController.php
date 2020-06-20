<?php

namespace App\Http\Controllers\Cargoorg;

use App\Models\Cargoorg;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CargoorgController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Cargoorg());
        
        //\DB::enableQueryLog();
        $query = Cargoorg::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);  

            if ($pageSize)
                $data =  $query->paginate($pageSize);
            else
                $data = $query->get();
        //dd(\DB::getQueryLog());
        
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
     * @param  \App\Models\Cargoorg  $cargoorg
     * @return \Illuminate\Http\Response
     */
    public function show(Cargoorg $cargoorg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cargoorg  $cargoorg
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargoorg $cargoorg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cargoorg  $cargoorg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cargoorg $cargoorg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cargoorg  $cargoorg
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cargoorg $cargoorg)
    {
        //
    }
}
