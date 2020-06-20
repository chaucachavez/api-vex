<?php

namespace App\Http\Controllers\Logacceso;

use App\Models\Logacceso;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class LogaccesoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Logacceso());
              
        $betweenDate = []; 
        if (request()->filled(['fechaingresoFrom', 'fechaingresoTo'])) {
            $betweenDate = array(request()->input('fechaingresoFrom'), request()->input('fechaingresoTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Logacceso::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fechaingreso', $betweenDate);

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
     * @param  \App\Models\Logacceso  $logacceso
     * @return \Illuminate\Http\Response
     */
    public function show(Logacceso $logacceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logacceso  $logacceso
     * @return \Illuminate\Http\Response
     */
    public function edit(Logacceso $logacceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logacceso  $logacceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logacceso $logacceso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logacceso  $logacceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logacceso $logacceso)
    {
        //
    }
}
