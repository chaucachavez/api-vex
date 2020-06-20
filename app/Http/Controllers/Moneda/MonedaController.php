<?php

namespace App\Http\Controllers\Moneda;

use App\Models\Moneda;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class MonedaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Moneda());
           
        //\DB::enableQueryLog();
        $query = Moneda::with($resource)
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
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function show(Moneda $moneda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function edit(Moneda $moneda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Moneda $moneda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moneda $moneda)
    {
        //
    }
}
