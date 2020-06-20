<?php

namespace App\Http\Controllers\Superperfil;

use App\Models\Superperfil;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SuperperfilController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Superperfil());
               
        //\DB::enableQueryLog();
        $query = Superperfil::with($resource)
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
     * @param  \App\Models\Superperfil  $superperfil
     * @return \Illuminate\Http\Response
     */
    public function show(Superperfil $superperfil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Superperfil  $superperfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Superperfil $superperfil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Superperfil  $superperfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Superperfil $superperfil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Superperfil  $superperfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Superperfil $superperfil)
    {
        //
    }
}
