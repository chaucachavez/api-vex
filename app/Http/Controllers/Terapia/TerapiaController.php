<?php

namespace App\Http\Controllers\Terapia;

use App\Models\Terapia;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TerapiaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Terapia());
              
        $betweenDate = []; 
        if (request()->filled(['fechaFrom', 'fechaTo'])) {
            $betweenDate = array(request()->input('fechaFrom'), request()->input('fechaTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Terapia::with($resource)
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
     * @param  \App\Models\Terapia  $terapia
     * @return \Illuminate\Http\Response
     */
    public function show(Terapia $terapia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Terapia  $terapia
     * @return \Illuminate\Http\Response
     */
    public function edit(Terapia $terapia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Terapia  $terapia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terapia $terapia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Terapia  $terapia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terapia $terapia)
    {
        //
    }
}
