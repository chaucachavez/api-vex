<?php

namespace App\Http\Controllers\Ciclo;

use App\Models\Ciclo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CicloController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Ciclo());
              
        $betweenDate = []; 
        if (request()->filled(['fechacierreFrom', 'fechacierreTo'])) {
            $betweenDate = array(request()->input('fechacierreFrom'), request()->input('fechacierreTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Ciclo::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fechacierre', $betweenDate);

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
     * @param  \App\Models\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Ciclo());

        $Ciclo = Ciclo::with($resource)
                ->findOrFail($id);
    
        return $this->showOne($Ciclo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function edit(Ciclo $ciclo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ciclo $ciclo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ciclo  $ciclo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ciclo $ciclo)
    {
        //
    }
}
