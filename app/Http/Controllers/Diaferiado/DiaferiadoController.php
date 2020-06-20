<?php

namespace App\Http\Controllers\Diaferiado;

use App\Models\Diaferiado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class DiaferiadoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Diaferiado());

        $likeFecha = request()->filled(['likeFecha']) ? request()->input('likeFecha') : NULL; 

        //\DB::enableQueryLog();
        $query = Diaferiado::with($resource)
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
            'fecha' => 'date'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all();

        $diaferiado = new Diaferiado;

        $diaferiado->fill($campos);  
 
        $diaferiado->idempresa = $idempresa;

        DB::beginTransaction(); 
        try {
            $diaferiado->save();          
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
     * @param  \App\Models\Diaferiado  $diaferiado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diaferiado $diasferiado)
    {   
        $idempresa = Config::get('constants.empresas.osi');   

        $reglas = [
            'fecha' => 'date'
        ];      

        $this->validate($request, $reglas); 

        $campos = $request->all();

        $diasferiado->fill($campos);     

        if (!$diasferiado->isDirty())
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);

        $diasferiado->idempresa = $idempresa;

        DB::beginTransaction(); 
        try {   
 
            $diasferiado->save(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($diasferiado); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diaferiado  $diasferiado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diaferiado $diasferiado)
    {
        $diasferiado->delete();   

        return $this->showOne($diasferiado);
    }
}
