<?php

namespace App\Http\Controllers\Producto;
 
use App\Models\Producto;
use App\Models\Ventadet;
use App\Models\Citamedica;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ProductosExport;
use App\Imports\ProductosImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductoController extends ApiController
{    
    public function __construct()
    {   
        $this->middleware('jwt');  
        $this->middleware('transform.input:' . Producto::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Producto());

        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL; 
        
        $fields = request()->filled(['fields']) ? explode(',', request()->input('fields'))  : NULL; 

        // \DB::enableQueryLog();
        $query = Producto::with($resource) 
            ->where($where)
            ->orderBy($orderName, $orderSort)     
            ->where('idempresa', auth()->user()->idempresa);

            if ($fields) {
                $query->select($fields);
            }

            if ($likeNombre) {  
                $query->where('nombre', 'like', '%' . $likeNombre . '%');
            }     
 
            if ($pageSize)
                $data = $query->paginate($pageSize);
            else
                $data = $query->get();

        // dd(\DB::getQueryLog());
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
            // 'idtipoproducto' => 'required',
            'nombre' => 'required|max:200',  
            'unidadmedida' => 'required'
        ];

        $this->validate($request, $reglas);

        //Validaciones con BD
        // 1. Codigo unico
        $existente = Producto::where('codigo', $request->codigo)
                ->where('idempresa', auth()->user()->idempresa)
                ->first();

        if ($existente) {
            return $this->errorResponse('Código interno ya existe.', 422); 
        } 

        // 2. nombre unico
        $existente = Producto::where('nombre', $request->nombre)
                ->where('idempresa', auth()->user()->idempresa)
                ->first();

        if ($existente) {
            return $this->errorResponse('Nombre ya existe.', 422); 
        }

        $producto = new Producto;

        $producto->fill($request->all());   
        $producto->idempresa = auth()->user()->idempresa;   
        $producto->id_created_at = auth()->user()->id;

        DB::beginTransaction(); 
        try { 
            $producto->save();    
        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($producto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Producto());
        
        $producto = Producto::with($resource)->findOrFail($id);
        // dd($producto->ventas()->exists());

        return $this->showOne($producto);
    }
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $reglas = [
            'tipo' => 'in:B,S', 
            'nombre' => 'filled|max:100',
            'coberturaind' => 'in:0,1',
            'ventaind' => 'in:0,1',
            'tratamientoind' => 'in:0,1',
            'seguroind' => 'in:0,1',
            'activo' => 'in:0,1', 
            'imagen' => 'image',
            'codigo' => 'max:50',
            'descripcion' => 'nullable' 
        ]; 

        $this->validate($request, $reglas); 

        // 1. Codigo unico
        $existente = Producto::where('codigo', $request->codigo)
                ->where('idempresa', auth()->user()->idempresa)
                ->whereNotIn('idproducto', [$producto->idproducto])
                ->first();

        if ($existente) {
            return $this->errorResponse('Código interno ya existe.', 422); 
        } 

        // 2. nombre unico
        $existente = Producto::where('nombre', $request->nombre)
                ->where('idempresa', auth()->user()->idempresa)
                ->whereNotIn('idproducto', [$producto->idproducto])
                ->first();

        if ($existente) {
            return $this->errorResponse('Nombre ya existe.', 422); 
        }


        $producto->fill($request->all());
        $producto->id_updated_at = auth()->user()->id;

        if (!$producto->isDirty())
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);

        $producto->save();

        return $this->showOne($producto);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        if ($producto->ventas()->exists()) 
        {
            return $this->errorResponse('Producto tiene ventas relacionadas.' , 422); 
        }

        // $this->verificarRelaciones($producto); 

        $producto->id_deleted_at = auth()->user()->id;

        DB::beginTransaction(); 
        try {   

            Storage::delete($producto->imgportada);             
            $producto->save(); 
            $producto->delete(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($producto);
    }


    protected function verificarRelaciones(Producto $producto)
    {    
        if(Ventadet::where('idproducto', $producto->idproducto)->first()) 
            throw new HttpException(422, "El producto especificado está presente en ventas.");
 
        // if(Citamedica::where('idproducto', $producto->idproducto)->first()) 
        //     throw new HttpException(422, "El producto especificado está presente en citas médicas.");        
    }

    public function updateimagen(Request $request, Producto $producto)
    {      

        $reglas = [ 
            'imagen' => 'required|file'
        ];  
 
        $this->validate($request, $reglas);        
 
        DB::beginTransaction(); 
        try {  

            if ($producto->imgportada) {
                Storage::delete($producto->imgportada);
            }

            $producto->imgportada = $request->imagen->store('empresas/1');  
            $producto->save(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($producto);
    }

    public function exportExcel() 
    {       
        
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Producto());        

        $stockMayor = request()->filled(['stockMayor']) ? request()->input('stockMayor') : NULL; 

        // \DB::enableQueryLog();
        $query = Producto::with(['categoria:nombre,id'])
        // $query = Producto::with(['categoria'])
            ->select('codigo', 'nombre', 'unidadmedida', 'moneda', 'valorcompra', 'valorventa', 'destacado', 'idimpuesto', 'codigosunat', 'stock', 'idcategoria')
            ->where($where)
            // ->where('idproducto', 8)
            ->where('idempresa', auth()->user()->idempresa)
            ->orderBy($orderName, $orderSort);       

        if ($stockMayor) {  
            $query->where('stock', '>', $stockMayor);
        }
 
        $data = $query->get();
        // dd(\DB::getQueryLog());

        $filename = 'productos' . Str::random() . '.xlsx';
        // dd($data);
        return (new ProductosExport($data))->download(Str::random() . '.xlsx');   
    }

    public function templateExcel() 
    {
        return response()->download(storage_path('app/plantilla_Productos.xlsx'));   
    }

    public function importExcel(Request $request)
    {     
        // return $this->showMessage("Cargado"); 
        // Validación de que exista archivo a cargar
        if (!$request->hasFile('UploadFiles')) {
            return $this->errorResponse("Debe enviar un archivo Excel.", 422);  
        }

        $file = $request->file('UploadFiles');   
        $fileName = $request->UploadFiles->getClientOriginalName(); 
        $fileExtension = $request->UploadFiles->getClientOriginalExtension(); // Falla: extension()
        $path = $request->UploadFiles->path();
        // return $this->errorResponse($fileName ."|". $fileExtension. "|".$path, 422);   

        // Validación de extensión de archivo
        if (!in_array($fileExtension, ['xls', 'xlsx']))  {
            $extension = !empty($fileExtension) ? '"' . mb_strtoupper($fileExtension) .'"' : ""; 
            return $this->errorResponse("Tipo de archivo " . $extension . " no es válido. Suba la plantilla Excel.", 422);  
        }

        // Validación de mover a disco
        $path = $request->UploadFiles->store('upload_productos', 'local');
        if (!$path) {  
            return $this->errorResponse('No se pudo guardar archivo ' . $fileName. " contacte con ventas@ifact.pe", 422);   
        }

        // Este atrapa el que no haya registro vacio. 
        try{ 
            $data = Excel::toArray(new ProductosImport, $file)[0]; // 'Productos.xlsx' 
            Log::info(print_r($data, true));   
        }catch ( ValidationException $e ){
            Log::info(print_r($e->errors(), true));   
            return $this->errorResponse($e->errors(), 422); 
        }   

        // Validacion de encabezados 
        $encabezado = array('codigo_deproductoobligatorio', 'nombre_de_productoobligatorio' ,'unidad_de_medidaobligatorio', 'monedaobligatorio', 'precio_compra_con_igv', 'precio_venta_con_igvobligatorio', 'impuesto_obligatorio', 'codigo_de_producto_sunat', 'destacado', 'nombre_de_categoria');

        $columns = array_keys($data[0]);
        $columnInvalid = null;       
        foreach($encabezado as $column) {
            if (!in_array($column, $columns)) {
                $columnInvalid = $column;
                break;
            }
        } 

        if ($columnInvalid) {
            return $this->errorResponse('No existe un encabezado correcto en archivo. Descargue plantilla Excel.', 422);
        } 

        // Validación por codigo de producto        
        $codigoIn = [];
        $nombreIn = [];
        foreach ($data as $value) {
            $codigoIn[] = $value['codigo_deproductoobligatorio'];
            $nombreIn[] = $value['nombre_de_productoobligatorio'];
        }

        $item = Producto::select('codigo')->whereIn('codigo', $codigoIn)->first(); 
        if ($item) {
            return $this->errorResponse('Código de producto "' . $item->codigo. '" ya existe.  Edite código o elimine la fila en archivo.', 422);   
        }

        // Validación por nombre de producto   
        $item = Producto::select('nombre')->whereIn('nombre', $nombreIn)->first(); 
        if ($item) {
            return $this->errorResponse('Nombre de producto "' . $item->nombre. '" ya existe.  Edite nombre o elimine la fila en archivo.', 422);   
        } 

        // Este atrapa las validaciones. 
        // Este atrapa el que no haya registro vacio. 
        try { 
            (new ProductosImport)->import($file); // 'plantilla_Productos.xlsx'
        } catch (\Exception $e) {
            if (method_exists($e,'failures')) {     
                $failures = $e->failures();
                $mensaje = $failures[0]->errors()[0];
                Log::info(print_r($failures[0]->errors(), true));   
                return $this->errorResponse($mensaje, 422);
            } else {
                Log::info(print_r($e->errors(), true));   
                return $this->errorResponse($e->errors(), 422); 
            }
        }

        return $this->showMessage("Cargado");
    }
}

