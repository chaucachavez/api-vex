<?php

namespace App\Http\Controllers\Masivo;
 
use App\Models\Masivo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Documentoserie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Venta\VentaController;
use App\Http\Controllers\Cronjobs\CronventaController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MasivoController extends ApiController
{    

    public $pathImg =  'C:\\xampp\\htdocs\\apiapp\\public\\';
    // public $pathImg =  '/home/centromedico/public_html/apiosi/public/comprobantes/';
    // public $pathImg =  '/home/ositest/public_html/apiosi/public/comprobantes/';

    public function __construct()
    {   
        $this->middleware('jwt');  
        $this->middleware('transform.input:' . Masivo::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Masivo());

        $betweenDate = []; 
        if (request()->filled(['fechaemisionFrom', 'fechaemisionTo'])) {
            $betweenDate = array(request()->input('fechaemisionFrom'), request()->input('fechaemisionTo'));
        }

        // \DB::enableQueryLog();
        $query = Masivo::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort)
            ->where('idempresa', auth()->user()->idempresa);
            
            if ($betweenDate) 
                $query->whereBetween('fechaemision', $betweenDate);
            
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
        // Validaciones con Request
        $reglas = [
            'fechaemision' => 'required',  
            'idsede' => 'required',
            'iddocumentofiscal' => 'required',
            'serie' => 'required'
        ];

        $this->validate($request, $reglas);

        // Validaciones con BD  
        // 1.- Comprobante tenga items
        if (!$request->masivodet) {
            return $this->errorResponse('Comprobante no tiene items.' , 422); 
        }

        // 2. Validar Factura
        if ($request->iddocumentofiscal == 1 && $request->clientedoc != 2) {
            return $this->errorResponse('Comprobante Factura requiere cliente RUC' , 422);
        }

        // 3.- Validar items 
        $impGravado = false;
        $totGravado = false; 
        $impExonerado = false;
        $impInafecta = false;
        $impGratuita = false;        
        $total = false;

        $dataVenta = $request->all();

        foreach($dataVenta['masivodet'] as $row) { 
            if ($row['idimpuesto'] === 1) {
                $impGravado = true;
                if ($row['montototalimpuestos'] <= 0) {
                    $totGravado = true;         
                } 
            }

            if ($row['idimpuesto'] === 8) {
                $impExonerado = true;                
            }

            if ($row['idimpuesto'] === 9) {
                $impInafecta = true;                
            }

            if (in_array($row['idimpuesto'], [2, 3, 4, 5, 6, 7, 10, 11, 12, 13, 14, 15])) {
                $impGratuita = true;
            }

            if ($row['total'] <= 0) {
                $total = true;
            }            
        }        
        
        if ($totGravado && $impGravado) {
            return $this->errorResponse('Invoice lines igv debe ser mayor que 0.0' , 422); 
        }

        if ($request->gravada <= 0 && $impGravado) {
            return $this->errorResponse('Total gravada debe ser mayor a cero' , 422); 
        }

        if ($request->valorimpuesto <= 0 && $impGravado) {
            return $this->errorResponse('Total igv debe ser mayor a cero' , 422); 
        }

        if ($request->gratuita <= 0 && $impGratuita) {
            return $this->errorResponse('Total gratuita debe ser mayor a cero' , 422); 
        }

        if ($request->exonerada <= 0 && $impExonerado) {
            return $this->errorResponse('Total exonerada debe ser mayor a cero' , 422); 
        }

        if ($request->inafecta <= 0 && $impInafecta) {
            return $this->errorResponse('Total inafecta debe ser mayor a cero' , 422); 
        }

        if ($total) {
            return $this->errorResponse('Invoice lines total debe ser mayor que 0' , 422); 
        }
        
        if ($request->total <= 0 && $request->gratuita <= 0) {
            return $this->errorResponse('Total debe ser mayor a cero' , 422); 
        }

        $documentoserie = Documentoserie::select('iddocumentoserie', 'numero')
                            ->where('iddocumentofiscal', $request->iddocumentofiscal)
                            ->where('idempresa', auth()->user()->idempresa)   
                            ->where('idsede', $request->idsede)
                            ->where('serie', $request->serie)
                            ->firstOrFail();

        $numerodel = $documentoserie->numero; 
        $numeroal = $documentoserie->numero + ($request->cantidad - 1); 

        DB::beginTransaction(); 
        try { 
            // Guarda masivo 
            $masivo = $this->guardarMasivo($request->all(), $numerodel, $numeroal); 
            
            // Guarda documentoserie
            $documentoserie->numero += $request->cantidad;
            $documentoserie->save(); 
            
        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();

        $cronVenta = new CronventaController(); 

        $cronVenta->generarComprobantesMasivos();

        $cronVenta->enviarComprobantesMasivos();

        return $this->showOne($masivo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Masivo());
        
        $masivo = Masivo::with($resource)->findOrFail($id); 

        return $this->showOne($masivo);
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
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
         
    }

    public function anular(Masivo $masivo)
    {          

        // Validaciones con BD  
        // 1.- No se encuentre anulado.
        if ($masivo->idestadodocumento === 28) {
            return $this->errorResponse('Comprobantes ya se encuentran anulados.', 422); 
        }

        // 1.- Fecha de emision maximo 5 dias
        $fechaMaxima = strtotime('-5 day', strtotime(date('Y-m-d')));
        $fechausuario = strtotime($masivo->fechaemision);

        if ($fechausuario < $fechaMaxima) {
            return $this->errorResponse('No procede. Transcurrió más de 5 dias desde la fecha de emisión', 422);
        } 


        DB::beginTransaction(); 
        try {   
            // \Log::info('Hola mundo');
            $masivo->idestadodocumento = 28;  
            $masivo->id_updated_at = auth()->user()->id;
            $masivo->save();

            $update = array(
                'idestadodocumento' => 28,
                'updated_at' => date('Y-m-d H:i:s'),
                'id_updated_at' => auth()->user()->id
            );

            DB::table('venta')
                 ->where('idmasivo', $masivo->id)
                 ->update($update);

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($masivo); 
    }

    public function guardarMasivo($campos, $numerodel, $numeroal) {        
        $masivo = new Masivo;

        $masivo->fill($campos);
        $masivo->progreso = 0; 
        $masivo->estado = 'I'; //Inicio
        $masivo->numerodel = $numerodel;
        $masivo->numeroal = $numeroal;
        $masivo->totalletra = $this->num2letras((float) $masivo->total);
        $tempor = (float) $masivo->total;
        
        $masivo->idempresa = auth()->user()->idempresa;
        $masivo->id_created_at = auth()->user()->id; 

        // Guarda venta
        $masivo->save();   

        // Guarda masivodet
        $detalle = array();
        foreach($campos['masivodet'] as $row) {
            $detalle[] = array(
                'idmasivo' => $masivo->id,
                'idproducto' => $row['idproducto'],
                'cantidad' => $row['cantidad'],
                'unidadmedida' => $row['unidadmedida'],
                'idimpuesto' => $row['idimpuesto'],
                'impuestobolsa' => $row['impuestobolsa'],
                'valorunit' => $row['valorunit'],
                'valorventa' => $row['valorventa'],
                'montototalimpuestos' => $row['montototalimpuestos'],
                'preciounit' => $row['preciounit'],                        
                'descuento' => $row['descuento'],
                'total' => $row['total'], 
                'codigo' => $row['codigo'],
                'codigosunat' => $row['codigosunat'],
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'id_created_at' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ); 
        }

        $masivo->masivodet()->insert($detalle); 

        return $masivo;
    }
}

