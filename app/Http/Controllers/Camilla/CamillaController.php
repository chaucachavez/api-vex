<?php

namespace App\Http\Controllers\Camilla;

use App\Models\Camilla;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CamillaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Camilla());
               
        //\DB::enableQueryLog();
        $query = Camilla::with($resource)
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
     * @param  \App\Models\Camilla  $camilla
     * @return \Illuminate\Http\Response
     */
    public function show(Camilla $camilla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Camilla  $camilla
     * @return \Illuminate\Http\Response
     */
    public function edit(Camilla $camilla)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Camilla  $camilla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camilla $camilla)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Camilla  $camilla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camilla $camilla)
    {
        //
    }
}
