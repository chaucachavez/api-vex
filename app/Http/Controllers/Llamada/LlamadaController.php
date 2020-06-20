<?php

namespace App\Http\Controllers\Llamada;

use App\Models\Llamada;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class LlamadaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Llamada());
              
        $betweenDate = []; 
        if (request()->filled(['fecharegistroFrom', 'fecharegistroTo'])) {
            $betweenDate = array(request()->input('fecharegistroFrom'), request()->input('fecharegistroTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Llamada::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fecharegistro', $betweenDate);

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
     * @param  \App\Models\Llamada  $llamada
     * @return \Illuminate\Http\Response
     */
    public function show(Llamada $llamada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Llamada  $llamada
     * @return \Illuminate\Http\Response
     */
    public function edit(Llamada $llamada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Llamada  $llamada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Llamada $llamada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Llamada  $llamada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Llamada $llamada)
    {
        //
    }
}
