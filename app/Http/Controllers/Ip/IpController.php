<?php

namespace App\Http\Controllers\Ip;

use App\Models\Ip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class IpController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Ip());
          
        //\DB::enableQueryLog();
        $query = Ip::with($resource)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {           
        $idempresa = Config::get('constants.empresas.osi');           
  
        // Validaciones con Request
        $reglas = [
            'nombre' => 'required'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all();

        $ip = new Ip;

        $ip->fill($campos);  
 
        $ip->idempresa = $idempresa;

        DB::beginTransaction(); 
        try {

            $ip->save();

        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($diaferiado); 
    }  

     

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ip $ip)
    {    
        $idempresa = Config::get('constants.empresas.osi');   

        $reglas = [
            'nombre' => 'required'
        ];      

        $this->validate($request, $reglas); 

        $campos = $request->all();

        $ip->fill($campos);     

        if (!$ip->isDirty())
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);


        DB::beginTransaction(); 
        try {   
 
            $ip->save(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($ip); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ip $ip)
    {
        $ip->delete();   

        return $this->showOne($ip);
    }
}
