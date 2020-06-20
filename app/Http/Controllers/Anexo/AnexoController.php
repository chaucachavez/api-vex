<?php

namespace App\Http\Controllers\Anexo;

use App\Models\Anexo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class AnexoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Anexo());
              
        $betweenDate = []; 
        if (request()->filled(['fechaopenFrom', 'fechaopenTo'])) {
            $betweenDate = array(request()->input('fechaopenFrom'), request()->input('fechaopenTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Anexo::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fechaopen', $betweenDate);

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
     * @param  \App\Models\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $this->fooShow($resource, new Anexo());

        $anexo = Anexo::with($resource)->findOrFail($id);
 
        return $this->showOne($anexo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function edit(Anexo $anexo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anexo $anexo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anexo $anexo)
    {
        //
    }
}
