<?php

namespace App\Http\Controllers\Ubigeo;

use App\Models\Provincia;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProvinciaController extends ApiController
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
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Provincia());
         
        //\DB::enableQueryLog();
        $query = Provincia::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($pageSize)
                $data = $query->paginate($pageSize);
            else
                $data = $query->get();

        if ($pageSize)
            $data = $query->paginate($pageSize);
        else
            $data = $query->get();

        //dd(\DB::getQueryLog());
        //dd($data);
        return $this->showPaginateAll($data);
    }

}
