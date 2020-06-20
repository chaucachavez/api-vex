<?php

namespace App\Http\Controllers\Diaxhora;
 
use App\Models\Diaxhora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class DiaxhoraController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Diaxhora());

        $likeFecha = request()->filled(['likeFecha']) ? request()->input('likeFecha') : NULL; 
             
        //\DB::enableQueryLog();
        $query = Diaxhora::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);             

            if ($likeFecha) {  
                $query->where('fecha', 'like', '%' . $likeFecha . '%');
            }

            if ($pageSize)
                $data =  $query->paginate($pageSize);
            else
                $data = $query->get();

        //dd(\DB::getQueryLog()); 
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
            'idsede' => 'required',
            'fecha' => 'date',
            'inicio' => 'required',
            'fin' => 'required'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all();

        $diaxhora = new Diaxhora;

        $diaxhora->fill($campos);  
 
        $diaxhora->idempresa = $idempresa;

        DB::beginTransaction(); 
        try {
            $diaxhora->save();          
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
     * @param  \App\Models\Diaxhora  $diaferiado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diaxhora $diaxhorae)
    {    
        $idempresa = Config::get('constants.empresas.osi');   

        $reglas = [
            'idsede' => 'required',
            'fecha' => 'date',
            'inicio' => 'required',
            'fin' => 'required'
        ];      

        $this->validate($request, $reglas); 

        $campos = $request->all();

        $diaxhorae->fill($campos);     

        if (!$diaxhorae->isDirty())
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);


        DB::beginTransaction(); 
        try {   
 
            $diaxhorae->save(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($diaxhorae); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diaxhora  $diaxhorae
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diaxhora $diaxhorae)
    {
        $diaxhorae->delete();   

        return $this->showOne($diaxhorae);
    }
}
