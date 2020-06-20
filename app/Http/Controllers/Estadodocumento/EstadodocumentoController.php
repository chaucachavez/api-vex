<?php

namespace App\Http\Controllers\Estadodocumento;
  
use Illuminate\Http\Request;
use App\Models\Estadodocumento;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class EstadodocumentoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Estadodocumento());
    
        //\DB::enableQueryLog();
        $query = Estadodocumento::with($resource)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estadodocumento  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function show(Estadodocumento $estado)
    { 
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estadodocumento  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estadodocumento $estado)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estadodocumento  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estadodocumento $estado)
    {
        
    }
}
