<?php

namespace App\Http\Controllers\Perfil;
 
use App\Models\Perfil;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class PerfilController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Perfil());
            
        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL;         

        //\DB::enableQueryLog();
        $query = Perfil::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            
        
        if ($likeNombre) 
            $query->where('nombre', 'LIKE', '%'. $likeNombre .'%');

        if ($pageSize)
            $data = $query->paginate($pageSize);
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

        $reglas = [
            'nombre' => 'required',
            'activo' => 'in:0,1'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all(); 
        $campos['idempresa'] = $idempresa;
        $campos['idsuperperfil'] = 2;

        $campos = $request->all();

        $perfil = new Perfil;

        $perfil->fill($campos);  
        $perfil->idempresa = $idempresa;
        $perfil->idsuperperfil = 2;

        $perfil->save();  

        return $this->showOne($perfil);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfile)
    {   
        $idempresa = Config::get('constants.empresas.osi');
        return $this->showOne($perfile);
        $reglas = [
            'nombre' => 'required',
            'activo' => 'in:0,1'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all(); 

        $perfile->fill($campos); 

        if($perfile->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        } 

        $perfile->idsuperperfil = 2;
        $perfile->save();

        return $this->showOne($perfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfile)
    {
        $perfile->delete();

        return $this->showOne($perfile);
    }
}
