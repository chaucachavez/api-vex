<?php

namespace App\Http\Controllers\Especialidad;
 
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class EspecialidadController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Especialidad());
    
        //\DB::enableQueryLog();
        $query = Especialidad::with($resource)
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
        $reglas = [
            'nombre' => 'required'
        ];

        $this->validate($request, $rules);

        $campos = $request->all();

        $campos['empresa_id'] = Config::get('constants.empresas.osi');

        $especialidad = Especialidad::create($campos); 

        return $this->showOne($especialidad);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function show(Especialidad $especialidade)
    { 
        return $this->showOne($especialidade);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Especialidad $especialidade)
    {
        $rules = [
            'nombre' => 'required'
        ];

        $this->validate($request, $rules);

        $campos = $request->intersect(['nombre']);

        $especialidade->fill($campos); 

        if($especialidade->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $especialidade->save();

        return $this->showOne($especialidade);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Especialidad $especialidade)
    {
        $especialidade->delete();

        return $this->showOne($especialidade);
    }
}
