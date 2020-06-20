<?php

namespace App\Http\Controllers\Categoria;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class CategoriaController extends ApiController
{

    public function __construct()
    {
        $this->middleware('jwt');  
        // dd(auth()->user());
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Categoria());
           
        //\DB::enableQueryLog();
        $query = Categoria::with($resource)
            ->where($where)
            ->where('idempresa', auth()->user()->idempresa)
            ->orderBy($orderName, $orderSort);              
            
            if ($pageSize)
                $data =  $query->paginate($pageSize);
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
        // Validaciones con Request        
        $reglas = [
            'codigo' => 'required',
            'nombre' => 'required'           
        ];

        $this->validate($request, $reglas);

        //Validaciones con BD
        // 1. Codigo unico
        $existente = Categoria::where('codigo', $request->codigo)
                ->where('idempresa', auth()->user()->idempresa)
                ->first();

        if ($existente) {
            return $this->errorResponse('Código ya existe.', 422); 
        }

        $categoria = new Categoria;

        $categoria->fill($request->all());   
        $categoria->idempresa = auth()->user()->idempresa; 
        $categoria->id_created_at = auth()->user()->id;

        DB::beginTransaction(); 
        try {

            $categoria->save();   

        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($categoria); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Categoria());

        // \DB::enableQueryLog();
        $categoria = Categoria::with($resource)
                        ->findOrFail($id); 
        // dd(\DB::getQueryLog());
        // Validaciones con JWT  
        if ($categoria->idempresa !== auth()->user()->idempresa ) {
            return $this->errorResponse('Restringido el acceso por permisos.', 422);
        }
    
        return $this->showOne($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $reglas = [
            'codigo' => 'required',
            'nombre' => 'required'
        ];      

        $this->validate($request, $reglas); 

        //Validaciones con BD
        // 1. Vlidar codigo unico
        $existente = Categoria::where('codigo', $request->codigo)
                    ->where('idempresa', auth()->user()->idempresa)
                    ->whereNotIn('idcategoria', [$categoria->idcategoria])
                    ->first();
                
        if ($existente) {
            return $this->errorResponse('Código ya existe.', 422); 
        }

        $categoria->fill($request->all());     
        $categoria->id_updated_at = auth()->user()->id;

        if (!$categoria->isDirty())
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);

        DB::beginTransaction(); 
        try {   
 
            $categoria->save();   

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($categoria); 
    }


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {       
        if ($categoria->productos()->exists()) {
            return $this->errorResponse('Categoria tiene productos relacionados.' , 422); 
        }

        DB::beginTransaction(); 
        try {   

            $categoria->id_deleted_at = auth()->user()->id;
            $categoria->save(); 
            $categoria->delete(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($categoria);
    }
}
