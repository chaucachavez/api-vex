<?php

namespace App\Http\Controllers\Documentoserie;

use Illuminate\Http\Request;
use App\Models\Documentoserie;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class DocumentoserieController extends ApiController
{   
    
    public function __construct()
    {
        $this->middleware('jwt');  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Documentoserie());
                  
        // \DB::enableQueryLog();
        $query = Documentoserie::with($resource) 
            ->where($where)
            ->where('idempresa', auth()->user()->idempresa) 
            ->orderBy($orderName, $orderSort);           

            if ($pageSize)
                $data =  $query->paginate($pageSize);
            else
                $data = $query->get();

        // dd(\DB::getQueryLog());
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
     * @param  \App\Models\Documentoserie  $documentoserie
     * @return \Illuminate\Http\Response
     */
    public function show(Documentoserie $documentoserie)
    {
        //
    }
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documentoserie  $documentoserie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documentoserie $documentoserie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documentoserie  $documentoserie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documentoserie $documentoserie)
    {
        //
    }
}
