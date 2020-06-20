<?php

namespace App\Http\Controllers\Aseguradoraplan;
 
use App\Models\Aseguradoraplan;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class AseguradoraplanController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Aseguradoraplan()); 

        //\DB::enableQueryLog();
        $query = Aseguradoraplan::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);       

            if ($pageSize)
                $data = $query->paginate($pageSize);
            else
                $data = $query->get();

        //dd(\DB::getQueryLog());
        //dd($data);
        return $this->showPaginateAll($data);    }

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
     * @param  \App\Models\Aseguradoraplan  $aseguradoraplan
     * @return \Illuminate\Http\Response
     */
    public function show(Aseguradoraplan $aseguradoraplan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aseguradoraplan  $aseguradoraplan
     * @return \Illuminate\Http\Response
     */
    public function edit(Aseguradoraplan $aseguradoraplan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aseguradoraplan  $aseguradoraplan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aseguradoraplan $aseguradoraplan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aseguradoraplan  $aseguradoraplan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aseguradoraplan $aseguradoraplan)
    {
        //
    }
}
