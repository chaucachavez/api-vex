<?php

namespace App\Http\Controllers\Empresa;

use App\Models\User;
use App\Models\EmpresaUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class EmpresaUsersController extends ApiController
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
        // dd($resource);
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new User()); 
         
        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL; 

        // DB::enableQueryLog(); 
        $query = User::with($resource)
                ->whereHas('empresa', function ($query) {
                    $query->where('empresa.idempresa', auth()->user()->idempresa);
                })
                ->where($where)
                ->orderBy($orderName, $orderSort);

        if ($likeNombre) 
            $query->where('name', 'LIKE', '%'. $likeNombre .'%'); 

        // dd($where);
        if ($pageSize)
            $data = $query->paginate($pageSize);
        else
            $data = $query->get();   
        
        // dd(DB::getQueryLog());
        // dd($data->toArray()['data']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
