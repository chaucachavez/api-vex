<?php

namespace App\Http\Controllers\Docidentidad;

use App\Models\Docidentidad;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DocidentidadController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Docidentidad());
        
        //\DB::enableQueryLog();
        $query = Docidentidad::with($resource)
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
     * @param  \App\Models\Docidentidad  $docidentidad
     * @return \Illuminate\Http\Response
     */
    public function show(Docidentidad $docidentidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Docidentidad  $docidentidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Docidentidad $docidentidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Docidentidad  $docidentidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docidentidad $docidentidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Docidentidad  $docidentidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docidentidad $docidentidad)
    {
        //
    }
}
