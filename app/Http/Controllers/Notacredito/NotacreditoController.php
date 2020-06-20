<?php

namespace App\Http\Controllers\Notacredito;

use App\Models\Notacredito;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class NotacreditoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Notacredito());
              
        $betweenDate = []; 
        if (request()->filled(['fechaFrom', 'fechaTo'])) {
            $betweenDate = array(request()->input('fechaFrom'), request()->input('fechaTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Notacredito::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fecha', $betweenDate);

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
     * @param  \App\Models\Notacredito  $notacredito
     * @return \Illuminate\Http\Response
     */
    public function show(Notacredito $notacredito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notacredito  $notacredito
     * @return \Illuminate\Http\Response
     */
    public function edit(Notacredito $notacredito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notacredito  $notacredito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notacredito $notacredito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notacredito  $notacredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notacredito $notacredito)
    {
        //
    }
}
