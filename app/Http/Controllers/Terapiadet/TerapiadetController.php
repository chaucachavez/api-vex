<?php

namespace App\Http\Controllers\Terapiadet;

use App\Models\Terapiadet;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TerapiadetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Terapiadet());
          
        //\DB::enableQueryLog();
        $query = Terapiadet::with($resource)
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
     * @param  \App\Models\Terapiadet  $terapiadet
     * @return \Illuminate\Http\Response
     */
    public function show(Terapiadet $terapiadet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Terapiadet  $terapiadet
     * @return \Illuminate\Http\Response
     */
    public function edit(Terapiadet $terapiadet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Terapiadet  $terapiadet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terapiadet $terapiadet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Terapiadet  $terapiadet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terapiadet $terapiadet)
    {
        //
    }
}
