<?php

namespace App\Http\Controllers\Docnegocio;

use App\Models\Docnegocio;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DocnegocioController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Docnegocio());
       
        //\DB::enableQueryLog();
        $query = Docnegocio::with($resource)
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
     * @param  \App\Models\Docnegocio  $docnegocio
     * @return \Illuminate\Http\Response
     */
    public function show(Docnegocio $docnegocio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Docnegocio  $docnegocio
     * @return \Illuminate\Http\Response
     */
    public function edit(Docnegocio $docnegocio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Docnegocio  $docnegocio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docnegocio $docnegocio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Docnegocio  $docnegocio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docnegocio $docnegocio)
    {
        //
    }
}
