<?php

namespace App\Http\Controllers\Sede;

use App\Models\Sede;
use App\Models\Sedehorario;
use Illuminate\Http\Request;
use App\Models\Documentoserie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class SedeController extends ApiController
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
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Sede());
        
        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL; 

        //\DB::enableQueryLog();
        $query = Sede::select('idsede', 'nombre', 'codigosunat', 'direccion', 'pdffactura', 'pdfboleta')
                    ->with($resource)
                    ->where($where)
                    ->where('idempresa', auth()->user()->idempresa)
                    ->orderBy($orderName, $orderSort);            
            
            if ($likeNombre) {  
                $query->where('nombre', 'like', '%' . $likeNombre . '%');
            }

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

        // Validaciones con Request        
        $reglas = [
            'nombre' => 'required',
            'codigosunat' => 'required',
            'direccion' => 'required',
            'pdffactura' => 'required_if:comercial,==,1',
            'pdfboleta' => 'required_if:comercial,==,1',
            'comprobantes' => 'filled'
        ];

        $this->validate($request, $reglas); 

        $sede = new Sede;

        $sede->fill($request->all());   
        $sede->idempresa = auth()->user()->idempresa; 
        $sede->id_created_at = auth()->user()->id;

        DB::beginTransaction(); 
        try {

            $sede->save();  

            if ($request->filled('comprobantes')) {   
                $data = array();
                foreach ($request->comprobantes as $value) {
                    $data[] = [
                        'idempresa' => auth()->user()->idempresa,
                        'contingencia' => $value['contingencia'],
                        'iddocumentofiscal' => $value['iddocumentofiscal'],
                        'numero' => $value['numero'],
                        'serie' => $value['serie']
                    ];
                }

                $sede->comprobantes()->createMany($data); 
            }

        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($sede); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        $this->fooShow($resource, new Sede());

        $sede = Sede::with($resource)
                ->findOrFail($id);

        // Validaciones con JWT  
        if ($sede->idempresa !== auth()->user()->idempresa ) {
            return $this->errorResponse('Restringido el acceso por permisos.', 422);
        }
    
        return $this->showOne($sede);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sede $sede)
    {          
        $reglas = [
            'nombre' => 'required',
            'codigosunat' => 'required',
            'pdffactura' => 'required_if:comercial,==,1',
            'pdfboleta' => 'required_if:comercial,==,1',
            'comprobantes' => 'filled'
        ];      

        $this->validate($request, $reglas); 
 
        $sede->fill($request->all());  
        $sede->id_updated_at = auth()->user()->id;   

        if (!$sede->isDirty() && $request->filled('sedehorario'))
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);

        DB::beginTransaction(); 
        try {   
 
            $sede->save();  

            if ($request->has('comprobantes')) {                 
                $sede->comprobantes()->delete();

                $data = array();
                foreach ($request->comprobantes as $value) {
                    $data[] = [
                        'idempresa' => auth()->user()->idempresa,
                        'contingencia' => $value['contingencia'],
                        'iddocumentofiscal' => $value['iddocumentofiscal'],
                        'numero' => $value['numero'],
                        'serie' => $value['serie']
                    ];
                }
                $sede->comprobantes()->createMany($data); 
            }

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($sede); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sede $sede)
    {   
        if ($sede->ventas()->exists()) {
            return $this->errorResponse('Sede tiene ventas relacionadas.' , 422); 
        }

        $sede->id_deleted_at = auth()->user()->id;

        DB::beginTransaction(); 
        try { 
            $sede->save(); 
            $sede->comprobantes()->delete();           
            $sede->delete();  
        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($sede);
    }
}
