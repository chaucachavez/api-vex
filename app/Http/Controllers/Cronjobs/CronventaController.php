<?php

namespace App\Http\Controllers\Cronjobs;
 
use App\Models\Venta;
use App\Models\Masivo;
use App\Models\Ventadet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Documentoserie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Venta\VentaController;
use App\Http\Controllers\Pdfs\invoiceMASIVOController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CronventaController extends ApiController
{    
    public $fields = ['idventa', 'idempresa', 'idsede', 'iddocumentofiscal', 'serie', 'numero', 'idcliente', 'fechaemision', 'idestadodocumento', 'exonerada', 'inafecta', 'gratuita', 'gravada', 'descuentoporcentaje', 'descuentoglobal', 'descuentoitem', 'descuentototal', 'valorimpuesto', 'cargo', 'total', 'totalletra', 'descripcion', 'clientenombre', 'clientedoc', 'clientenumerodoc', 'clientedireccion', 'cuentadetraccion', 'operacion', 'moneda', 'tipocambio', 'fechavencimiento', 'detraccion', 'selvaproducto', 'selvaservicio', 'placavehiculo', 'condicionpago', 'observacion', 'pdfformato', 'cpecorreo', 'idmasivo', 'id_created_at'];

    public function __construct()
    {   
        // $this->middleware('jwt');  //JWT: Token ausente
        $this->middleware('transform.input:' . Masivo::class)->only(['store', 'update']);
    } 

    public function generarComprobantesMasivos()
    {          
        // Cron ejecutado cada 1 minuto.
        // I: Inicio P:Proceso F:Finalizado
        $masivo = Masivo::with('masivodet')->where('estado', 'I')->first();
       
        if (!$masivo) {
            return $this->showMessage('No hay lotes de comprobantes a generar.'); 
        }

        if ($masivo) {
            // Guarda venta  
            $ventaController = new VentaController();  

            $fieldsDetalle = [];
            foreach ($masivo->masivodet as $ventadet) { 
                $fieldsDetalle[] = array(
                    'idproducto' => $ventadet->idproducto,
                    'cantidad' => $ventadet->cantidad,
                    'unidadmedida' => $ventadet->unidadmedida,
                    'idimpuesto' => $ventadet->idimpuesto,
                    'valorunit' => $ventadet->valorunit,
                    'valorventa' => $ventadet->valorventa,
                    'impuestobolsa' =>  $ventadet->impuestobolsa,
                    'montototalimpuestos' => $ventadet->montototalimpuestos,
                    'preciounit' => $ventadet->preciounit,
                    'descuento' => $ventadet->descuento,
                    'total' => $ventadet->total,
                    'codigo' => $ventadet->codigo,
                    'codigosunat' => $ventadet->codigosunat,
                    'nombre' => $ventadet->nombre,
                    'descripcion' => $ventadet->descripcion,
                    'created_at' => $ventadet->created_at,
                    'id_created_at' => $ventadet->id_created_at
                );
            }
 
            $fieldsVenta = array(
                'idempresa' => $masivo->idempresa,
                'idsede' => $masivo->idsede,
                'fechaemision' => $masivo->fechaemision,
                'iddocumentofiscal' => $masivo->iddocumentofiscal,
                'serie' => $masivo->serie, 
                'numero' => null, 
                'idestadodocumento' => $masivo->idestadodocumento, 
                'idcliente' => $masivo->idcliente, 
                'exonerada' => $masivo->exonerada,
                'inafecta' => $masivo->inafecta,
                'gratuita' => $masivo->gratuita,
                'gravada' => $masivo->gravada,
                'descuentoporcentaje' => $masivo->descuentoporcentaje,
                'descuentoglobal' => $masivo->descuentoglobal,
                'descuentoitem' => $masivo->descuentoitem,
                'descuentototal' => $masivo->descuentototal,
                'valorimpuesto' => $masivo->valorimpuesto,
                'cargo' => $masivo->cargo,
                'totalimpuestobolsa' => $masivo->totalimpuestobolsa,
                'total' => $masivo->total,
                'totalletra' => $masivo->totalletra,
                'clientenombre' => $masivo->clientenombre,
                'clientedoc' => $masivo->clientedoc,
                'clientenumerodoc' => $masivo->clientenumerodoc,
                'clientedireccion' => $masivo->clientedireccion,
                'operacion' => $masivo->operacion,
                'moneda' => $masivo->moneda,
                'tipocambio' => $masivo->tipocambio,
                'fechavencimiento' => $masivo->fechavencimiento,
                'detraccion' => $masivo->detraccion,
                'selvaproducto' => $masivo->selvaproducto,
                'selvaservicio' => $masivo->selvaservicio,
                'condicionpago' => $masivo->condicionpago,
                'observacion' => $masivo->observacion, 
                'pdfformato' => $masivo->pdfformato, 
                'created_at' => $ventadet->created_at,
                'id_created_at' => $ventadet->id_created_at,
                'ventadet' => $fieldsDetalle
            );

            $masivo->estado = 'P';
            $masivo->save();
            $inicio = $masivo->numerodel;
            $fin = $masivo->numeroal;

            for ($i=$inicio; $i<=$fin; $i++) { 
                DB::beginTransaction(); 
                try {
                    $fieldsVenta['numero'] = $i;                         
                    $venta = $ventaController->guardarVenta($fieldsVenta, $masivo->id);
                } catch (QueryException $e) {
                    DB::rollback();
                }        
                DB::commit();
            }

            $masivo->estado = 'PP';
            $masivo->save();
            /*$inicio = $masivo->numerodel + $masivo->progreso;
            $fin = $masivo->numeroal; */

            // for ($i=$inicio; $i<=$fin; $i++) {  
            //     // Guardar masivo
            //     $masivo->estado = 'P';
            //     $masivo->progreso += 1; 
            //     Log::info($masivo->numeroal . '-'. $masivo->numerodel . '+1 === '.$masivo->progreso);
            //     if (($masivo->numeroal - $masivo->numerodel + 1) === $masivo->progreso) {
            //         $masivo->estado = 'F';
            //     }
            //     $masivo->save();
        }
        // dd($masivo); 
        return $this->showOne($masivo);
    }

    public function enviarComprobantesMasivos()
    {
        // Cron ejecutado cada 1 minuto.
        // I: Inicio P:Proceso F:Finalizado
        $masivo = Masivo::with('masivodet')->where('estado', 'PP')->first();
       
        if (!$masivo) {
            return $this->showMessage('No hay lotes de comprobantes a enviar.'); 
        }

        if ($masivo) {
            // Guarda venta  
            $ventaController = new VentaController();  

            $data = Venta::select('idventa')
                        ->where('idmasivo', $masivo->id)
                        // ->whereNull('sunat_aceptado') // Condición para PSE
                        ->whereNull('xml') // Condición para Firma con Certificado
                        ->get();

            if (empty($data)) {
                Log::info('No hay comprobantes de lote #' . $masivo->id); 
                return $this->showMessage('No hay comprobantes de lote #' . $masivo->id); 
            }

            if ($data) {
                // dd($masivo->idmasivo, $data->toArray());
                $masivo->estado = 'F';
                $masivo->save(); 

                foreach ($data as $venta) { 
                    if (true) {
                        // SUNAT
                        // Enviar a Firma con Certificado
                        $leer_respuesta = $ventaController->emitirComprobanteLocal($venta->idventa); 
                    } else {
                        // PSE
                        // Enviar a PSE
                        $leer_respuesta = $ventaController->emitirComprobante($venta->idventa);           
                    }

                    if ($leer_respuesta['codigo']) {
                        $masivo->progreso += 1;
                        $masivo->save();

                        // Generar PDF
                        $leer_respuesta = $ventaController->generarPDF($venta->idventa); 
                    }
                }

                if ($masivo->progreso === $masivo->cantidad) {
                    $masivo->estado = 'FF';
                    $masivo->save();
                }

                // Unir PDFs
                if ($masivo->estado === 'FF') {

                    $invoiceMasivo = new invoiceMASIVOController(); 

                    $data = $invoiceMasivo->reporte($masivo->id, true);

                    if ($data['generado'] === 1) {
                        $masivo->pdf = $data['mensaje'];
                        $masivo->save();
                    }
                }
            }
        }
        // dd($masivo); 
        return $this->showOne($masivo);
    }
}

