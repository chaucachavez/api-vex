<?php

namespace App\Http\Controllers\Autorizacion;

use App\Models\Autorizacion;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class AutorizacionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Autorizacion());
              
        $betweenDate = []; 
        if (request()->filled(['fechaFrom', 'fechaTo'])) { 
            $betweenDate = array(request()->input('fechaFrom'), request()->input('fechaTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Autorizacion::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);  
                      
            if ($betweenDate) 
                $query->whereBetween('fecha', $betweenDate);

            if ($pageSize)
                $data =  $query->paginate($pageSize);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $this->fooShow($resource, new Autorizacion());

        $autorizacion = Autorizacion::with($resource)->findOrFail($id);
 
        return $this->showOne($autorizacion);
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Autorizacion $autorizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autorizacion $autorizacion)
    {
        //
    }
}
