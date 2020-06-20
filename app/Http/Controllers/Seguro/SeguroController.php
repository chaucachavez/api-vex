<?php

namespace App\Http\Controllers\Seguro;

use App\Models\Seguro;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SeguroController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Seguro());
          
        //\DB::enableQueryLog();
        $query = Seguro::with($resource)
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
     * @param  \App\Models\Seguro  $seguro
     * @return \Illuminate\Http\Response
     */
    public function show(Seguro $seguro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seguro  $seguro
     * @return \Illuminate\Http\Response
     */
    public function edit(Seguro $seguro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seguro  $seguro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seguro $seguro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seguro  $seguro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seguro $seguro)
    {
        //
    }
}
