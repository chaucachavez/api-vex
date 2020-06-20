<?php

namespace App\Http\Controllers\Apertura;
 
use App\Models\Apertura;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator; 

class AperturaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Apertura());
              
        $betweenDate = []; 
        if (request()->filled(['fechacloseFrom', 'fechacloseTo'])) {
            $betweenDate = array(request()->input('fechacloseFrom'), request()->input('fechacloseTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Apertura::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fechaclose', $betweenDate);

            if ($pageSize)
                $data =  $query->paginate($pageSize);
            else
                $data = $query->get();

        //dd(\DB::getQueryLog());
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
     * @param  \App\Models\Apertura  $apertura
     * @return \Illuminate\Http\Response
     */
    public function show(Apertura $apertura)
    {
        return $this->showOne($apertura);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apertura  $apertura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apertura $apertura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apertura  $apertura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apertura $apertura)
    { 
        
        $apertura->delete();

        return $this->showOne($apertura);
    }
}
