<?php

namespace App\Http\Controllers\Venta;
 
use App\Models\Venta;
use App\Models\Moneda;
use App\Pdfs\VentaPdf;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Apertura;
use App\Mail\InvoiceSend;
use App\Models\Citamedica;
use App\Models\Docnegocio;
use Illuminate\Support\Str;
use App\Exports\VentaExport;
use Illuminate\Http\Request;
use App\Models\Documentoserie;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Pdfs\invoiceA4Controller;
use App\Http\Controllers\Pdfs\invoiceA5Controller;
use App\Http\Controllers\Pdfs\invoiceTICKETController; 

class VentaController extends ApiController
{
    // public $pathImg =  'C:\\xampp\\htdocs\\apiapp\\public\\';
    // public $pathImg =  '/home/app/public_html/api/public/';
    public $pathImg =  '';
    public $pathQr = '';
    public $pathPdf = '';
    public $pathCdr = '';
    public $pathXml = '';

    public function __construct()
    {        
        $this->middleware('jwt');

        if (auth()->user()) {
            $rutaempresa = public_path() . DIRECTORY_SEPARATOR . 'empresa' . 
                            DIRECTORY_SEPARATOR . auth()->user()->idempresa . 
                            DIRECTORY_SEPARATOR;

            $this->pathPdf = $rutaempresa . 'pdf' . DIRECTORY_SEPARATOR;        
            $this->pathXml = $rutaempresa . 'xml' . DIRECTORY_SEPARATOR;
            $this->pathCdr = $rutaempresa . 'cdr' . DIRECTORY_SEPARATOR;
            $this->pathQr = $rutaempresa . 'qr' . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Venta());

        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL; 
              
        $betweenDate = []; 
        if (request()->filled(['fechaemisionFrom', 'fechaemisionTo'])) {
            $betweenDate = array(request()->input('fechaemisionFrom'), request()->input('fechaemisionTo')); 
        } 

        $betweenNumero = [];
        if (request()->filled(['numeroFrom', 'numeroTo'])) {
            $betweenNumero = array(request()->input('numeroFrom'), request()->input('numeroTo')); 
        } 
        // dd();
        // \DB::enableQueryLog();
        $query = Venta::with($resource)
            ->where($where)
            ->where('idempresa', auth()->user()->idempresa) 
            ->orderBy($orderName, $orderSort);        

            if ($likeNombre) { 
                $query->join('entidad as cliente', 'venta.idcliente', '=', 'cliente.identidad');
                $query->where('cliente.entidad', 'like', '%' . $likeNombre . '%');
            }

            if ($betweenDate) 
                $query->whereBetween('fechaemision', $betweenDate);

            if ($betweenNumero) 
                $query->whereBetween('numero', $betweenNumero);

            if ($pageSize)
                $data = $query->paginate($pageSize);
            else
                $data = $query->get();

        // dd(\DB::getQueryLog()); 
        return $this->showPaginateAll($data);
    }  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Venta());

        $venta = Venta::with($resource)->findOrFail($id);
        
        // Validaciones con JWT  
        if ($venta->idempresa !== auth()->user()->idempresa ) {
            return $this->errorResponse('Restringido el acceso por permisos.', 422);
        }

        return $this->showOne($venta);
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
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
            'idsede' => 'required',
            'iddocumentofiscal' => 'required',
            'serie' => 'required',
            'numero' => 'required',
            'idcliente' => 'required',
            'idestadodocumento' => 'required',
            'tiponc' => 'required_if:iddocumentofiscal,==,10,13',
            'documentonc' => 'required_if:iddocumentofiscal,==,10,13',
            'serienc' => 'required_if:iddocumentofiscal,==,10,13|nullable|string|between:3,4',
            'numeronc' => 'required_if:iddocumentofiscal,==,10,13',
        ];

        $this->validate($request, $reglas);

        // Validaciones con BD  

        // 1.- Comprobante tenga items
        if (!$request->ventadet) {
            return $this->errorResponse('Comprobante no tiene items.' , 422); 
        }

        // 2. Validar Factura
        if ($request->iddocumentofiscal == 1 && $request->clientedoc != 2) {
            return $this->errorResponse('Comprobante Factura requiere cliente RUC' , 422);
        }

        // 3. Validar Medios de Pago
        if ($request->has('ventapago') && !$request->ventapago) {
            return $this->errorResponse('Comprobante no tiene medios de pago.' , 422);
        } 

        // 4.- Correlativo de comprobante este libre
        $where = array( 
            'idempresa' => auth()->user()->idempresa,
            'iddocumentofiscal' => $request->iddocumentofiscal,
            'serie' => $request->serie,
            'numero' => $request->numero,
        ); 

        $ventaNumero = Venta::with('docnegocio')->where($where)->first(); 

        if ($ventaNumero) {
            return $this->errorResponse('Correlativo ya se encuentra emitido' , 422); 
        }  

        // 5.- Serie en comprobante exista
        $where = array(
            'idempresa' => auth()->user()->idempresa,
            'iddocumentofiscal' => $request->iddocumentofiscal,
            'serie' => $request->serie,
            'numero' => $request->numero 
        ); 

        $documentoserie = Documentoserie::where($where)->first();

        if (empty($documentoserie)) {
            return $this->errorResponse('No existe correlativo' , 422); 
        }

        // 6.- Validar items 
        // Log::info(gettype($request->detraccion));
        $impGravado = false;
        $totGravado = false; 
        $impExonerado = false;
        $impInafecta = false;
        $impGratuita = false;        
        $total = false;

        $dataVenta = $request->all();

        foreach($dataVenta['ventadet'] as $row) { 
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

        // 6.- Validar comprobante a emitir NC/ND 
        if ($request->iddocumentofiscal === 10 || $request->iddocumentofiscal === 13) {
            if (strlen($request->serienc) === 3) { //Físico                
                if (substr($request->serienc, 0, 2) !== '00') {
                    return $this->errorResponse('Dos primero digitos de Serie debe ser "00"' , 422);
                }
            }

            if (strlen($request->serienc) === 4) { //Electronico

                $primerCaracter = substr($request->serienc, 0, 1);
                $modifica = $request->documentonc === 1 ? 'Factura ' : 'Boleta de venta ';

                if ($request->documentonc === 1 && $primerCaracter !== 'F') {
                    return $this->errorResponse('Serie de '.$modifica.' debe empezar con "F"' , 422);
                }

                if ($request->documentonc === 2 && $primerCaracter !== 'B') {
                    return $this->errorResponse('Serie de '.$modifica.' debe empezar con "B"' , 422);
                }
            }

            $where = array( 
                'idempresa' => auth()->user()->idempresa,
                'iddocumentofiscal' => $request->documentonc,
                'serie' => $request->serienc,
                'numero' => $request->numeronc
            ); 
            
            $ventaModifica = Venta::with('docnegocio')->where($where)->first();
            if (!$ventaModifica) {
                $comprobante = $request->iddocumentofiscal === 13 ? 'Nota de crédito ' : 'Nota de débito ';
                $modifica = $request->documentonc === 1 ? 'Factura ' : 'Boleta de venta ';
                $modifica .= $request->serienc .' - ' . $request->numeronc;

                return $this->errorResponse('Comprobante a emitir '.$comprobante.'"'.$modifica.'". 
                                             No existe' , 422); 
            }
        }

        // return $this->errorResponse('XD' , 422); 

        DB::beginTransaction(); 
        try {              
            // Guarda venta
            $venta = $this->guardarVenta($request->all()); 

            // Guarda documentoserie
            $documentoserie->numero = $documentoserie->numero + 1;
            $documentoserie->save();
        } catch (QueryException $e) {
            DB::rollback();
        }
        DB::commit();


        if (true) {
            // SUNAT
            // Enviar a Firma con Certificado
            $leer_respuesta = $this->emitirComprobanteLocal($venta->idventa); 
            Log::info($leer_respuesta); 

        } else {
            // PSE
            // Enviar a PSE
            $leer_respuesta = $this->emitirComprobante($venta->idventa); 
            Log::info($leer_respuesta);             
        }
        
        // Generar PDF
        if ($leer_respuesta['codigo']) {
            $leer_respuesta = $this->generarPDF($venta->idventa);  
            Log::info($leer_respuesta);          
        }

        // Enviar PDF correo
        // Delegamos envíos al CRON por tomarse (+3 seg.)
        // if (!empty($venta->cpecorreo)) {
        //     $leer_respuesta = $this->enviarCorreo($venta->idventa);
        //     Log::info($leer_respuesta);
        // }

        return $this->showOne($venta); 
    }

    public function guardarVenta($campos, $idmasivo = NULL) {        

        $venta = new Venta;

        $venta->fill($campos);
        
        $venta->idmasivo = $idmasivo;    
        $venta->totalletra = $this->num2letras((float) $venta->total);
        $venta->idempresa = isset($campos['idempresa']) ? $campos['idempresa'] : auth()->user()->idempresa;
        $venta->id_created_at = isset($campos['id_created_at']) ? $campos['id_created_at'] : auth()->user()->id; 
        
        if (isset($campos['detraccion']) && $campos['detraccion'] === '1') { 
            $empresa = Empresa::select('ctadetraccion')->findOrFail($venta->idempresa);
            $venta->cuentadetraccion = $empresa->ctadetraccion; 
            Log::info($venta->cuentadetraccion); 
        }

        // Guarda venta
        $venta->save();   

        // Guarda ventadet
        $detalle = array();
        foreach($campos['ventadet'] as $row) {
            $detalle[] = array(
                'idventa' => $venta->idventa,
                'idproducto' => $row['idproducto'],
                'cantidad' => $row['cantidad'],
                'unidadmedida' => $row['unidadmedida'],
                'idimpuesto' => $row['idimpuesto'],
                'valorunit' => $row['valorunit'],
                'valorventa' => $row['valorventa'],
                'impuestobolsa' => $row['impuestobolsa'],
                'montototalimpuestos' => $row['montototalimpuestos'],
                'preciounit' => $row['preciounit'],                        
                'descuento' => isset($row['descuento']) ? $row['descuento'] : null,
                'total' => $row['total'], 
                'codigo' => $row['codigo'],
                'codigosunat' => $row['codigosunat'],
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'id_created_at' => isset($row['id_created_at']) ? $row['id_created_at'] : auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ); 
        }

        $venta->ventadet()->insert($detalle);    

        // Guarda ventapago
        if (isset($campos['ventapago'])) {
            $pagos = array();
            foreach($campos['ventapago'] as $row) {
                $pagos[] = array(
                    'idventa' => $venta->idventa,
                    'idmediopago' => $row['idmediopago'],
                    'importe' => $row['importe'],
                    'nota' => $row['nota'], 
                    'id_created_at' => isset($row['id_created_at']) ? $row['id_created_at'] : auth()->user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ); 
            }

            $venta->ventapago()->insert($pagos);  
        }

        return $venta;
    }

    public function anulacion(Venta $venta)
    {          
        // $venta = Venta::with('ventadet')->findOrFail($id); 

        // Validaciones con BD  
        // 1.- No se encuentre anulado.
        if ($venta->idestadodocumento === 26) {
            return $this->errorResponse('Comprobante no puede anularse, es un Borrador.' , 422); 
        } 

        if ($venta->idestadodocumento === 28) {
            return $this->errorResponse('Comprobante ya se encuentra anulado.' , 422); 
        } 

        // 2.- No tenga nota de crédito
        $where = array(
            'idempresa' => $venta->idempresa,
            'documentonc' => $venta->iddocumentofiscal,
            'serienc' => $venta->serie,
            'numeronc' => $venta->numero,
        );

        $ventaref = Venta::where($where)->first();  
        if ($ventaref) {
            return $this->errorResponse('Comprobante no puede anularse, tiene Nota de crédito'.$ventaref->serie.' - '.$ventaref->numero, 422); 
        }

        // 3.- Fecha máxima para anular
        $fechaMaxima = strtotime('-5 day', strtotime(date('Y-m-d')));
        $fechaEmision = strtotime($venta->fechaemision); 

        if ($fechaEmision < $fechaMaxima && in_array($venta->iddocumentofiscal, [1,2,10,13])) {
            return $this->errorResponse('Comprobante no puede anularse, transcurrió más de 5 dias.', 422);
        }

        $venta->idestadodocumento = 28;
        $venta->id_updated_at = auth()->user()->id;
        $venta->idpersonalanula = auth()->user()->id;

        DB::beginTransaction(); 
        try { 

            $leer_respuesta = $this->anularComprobante($venta->idventa); 

            if (isset($leer_respuesta['aceptada_por_sunat']) && !isset($leer_respuesta['errors'])) {
                Log::info($leer_respuesta);
                if (strlen($leer_respuesta['sunat_soap_error']) > 50) { // Capturar error propios de SUNAT
                    $leer_respuesta['sunat_soap_error'] = substr($leer_respuesta['sunat_soap_error'], 0, 50);
                }

                $venta->sunat_anulado_ticket = $leer_respuesta['sunat_ticket_numero'];
                $venta->sunat_anulado_aceptado = $leer_respuesta['aceptada_por_sunat'] === TRUE ? '1' : '0';
                $venta->sunat_anulado_nota = $leer_respuesta['sunat_description'];
                $venta->sunat_anulado_nota .= '|' . $leer_respuesta['sunat_note'];
                $venta->sunat_anulado_nota .= '|' . $leer_respuesta['sunat_responsecode'];
                $venta->sunat_anulado_nota .= '|' . $leer_respuesta['sunat_soap_error'];
                $venta->sunat_anulado_key = $leer_respuesta['key'];
                $venta->save();                
            } else {
                if (isset($leer_respuesta['errors'])) {
                    $mensaje = $leer_respuesta['codigo'] . ' - ' .$leer_respuesta['errors'];
                } else {
                    $mensaje = 'Error en envio a [PSE]';
                }

                Log::info($leer_respuesta); 
                return $this->errorResponse($mensaje, 422); 
            }

        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($venta); 
    }  

    public function saveXml(Request $request) { 

        Storage::disk('local')->put($request->documento, base64_decode($request->contenido)); 
        
        return response()->download(storage_path('app/') . $request->documento); 
    }

    public function exportExcel() 
    {             
        $filename = Str::random() . '.xlsx';

        return (new VentaExport(['2019-02-06', '2019-02-08']))->download($filename);
        // Excel::store(new VentaExport(['2019-02-06', '2019-02-08']), $filename, 'local');
    }

    public function exportPdf(Request $request) 
    {     
        // Diferencia entre 'asset' y 'storage_path'
        // 'http://apiclinicanet.pe/temporal/9cqT6GqS3tTVb5zm.pdf'; //asset('temporal/' . $filename)
        // 'C:\xampp\htdocs\apiclinicanet\storage\app/9ux6IAKH2dXRnNoD.pdf' //storage_path('app/') . $filename
        
        //  D.Forzada y grabado
        $filename = Str::random() . '.pdf'; 
        (new VentaPdf($request))->download($filename, true);

        return response()->download(storage_path('app/') . $filename);
        // D.En navegador
        // return (new VentaPdf($request))->download(); 
    }

    public function generarPDF($idventa, $tipo = null) {

        $venta = Venta::select('idventa', 'qr','hash','pdfformato')->find($idventa);  

        if (empty($venta->qr)) {  
            return array('codigo' => false, 'mensaje' => 'QR no existe');
        }

        if (!empty($tipo)) {
            $formato = $tipo;
        } else {
            $formato = $venta->pdfformato;
        }

        $invoice = null;
        switch ($formato) { 
            case 'A4': 
                $invoice = new invoiceA4Controller(); 
                break; 
            case 'A5': 
                $invoice = new invoiceA5Controller();
                break; 
            case 'TICKET': 
                $invoice = new invoiceTICKETController();
                break; 
            default:  
                break;
        } 

        $data = $invoice->reporte($venta->idventa, true);
 
        if ($data['generado'] === 1) {

            $venta->pdf = $data['mensaje'] .'.pdf';
            $venta->save();  

            $data = array('codigo' => true, 'mensaje' => 'PDF generado');
        } else {
            $data = array('codigo' => false, 'mensaje' => 'PDF no generado');
        }

        return $data;
    }

    public function regenerarPdf(Request $request, $idventa) {

        $venta = Venta::select('idventa', 'qr', 'hash', 'pdfformato', 'sunat_aceptado')->findOrFail($idventa);

        if (is_null($venta->sunat_aceptado)) {  
            // Enviar a PSE
            $leer_respuesta = $this->emitirComprobante($venta->idventa);
            Log::info($leer_respuesta);

            // De ser falso, consultamos el "estado" de emision del comprobante.
            if (!$leer_respuesta['codigo']) {
                
                // Consultar a PSE
                $leer_respuesta = $this->consultarEmision($venta->idventa);
                Log::info($leer_respuesta); 

                if (isset($leer_respuesta['aceptada_por_sunat']) && !isset($leer_respuesta['errors'])) {

                    if (strlen($leer_respuesta['sunat_soap_error']) > 50) { // Capturar error propios de SUNAT
                        $leer_respuesta['sunat_soap_error'] = substr($leer_respuesta['sunat_soap_error'], 0, 50);
                    }
                    
                    $venta = Venta::select('idventa', 'serie', 'numero', 'idempresa', 'iddocumentofiscal')
                                ->with('empresa:idempresa,ruc',  'docnegocio:iddocumentofiscal,codigosunat')
                                ->findOrFail($idventa);

                    $fileName = $venta->empresa->ruc . '-' . 
                                $venta->docnegocio->codigosunat . '-' . 
                                $venta->serie . '-' . 
                                $venta->numero;

                    $venta->sunat_aceptado = $leer_respuesta['aceptada_por_sunat'] === TRUE ? '1' : '0';
                    $venta->sunat_nota = $leer_respuesta['sunat_description'];
                    $venta->sunat_nota .= '|' . $leer_respuesta['sunat_note'];
                    $venta->sunat_nota .= '|' . $leer_respuesta['sunat_responsecode'];
                    $venta->sunat_nota .= '|' . $leer_respuesta['sunat_soap_error'];
                    $venta->hash = $leer_respuesta['codigo_hash'];
                    $venta->enlace = $leer_respuesta['enlace_del_pdf'];

                    // Almacenar XML
                    if (isset($leer_respuesta['enlace_del_xml']) && !empty($leer_respuesta['enlace_del_xml'])) {
                        $nombre = $this->pathXml . $fileName . '.xml';
                        file_put_contents($nombre, fopen($leer_respuesta['enlace_del_xml'], 'r')); 

                        if (file_exists($nombre)) {
                            $venta->xml = $fileName .'.xml';
                        }
                    }

                    // Almacenar CDR
                    if (isset($leer_respuesta['enlace_del_cdr']) && !empty($leer_respuesta['enlace_del_cdr'])) {
                        Log::info('Por almacenar CDR');
                        $nombre = $this->pathCdr . 'CDR_' . $fileName . '.xml';
                        file_put_contents($nombre, fopen($leer_respuesta['enlace_del_cdr'], 'r'));
                        
                        if (file_exists($nombre)) {
                            $venta->cdr = 'CDR_' . $fileName .'.xml';
                            Log::info('Almacenado ' . $nombre);
                        }
                    }

                    // Almacenar Imagen QR
                    if (isset($leer_respuesta['cadena_para_codigo_qr']) && !empty($leer_respuesta['cadena_para_codigo_qr'])) {
                        $nombre = $this->pathQr . $fileName . '.png';
                        QrCode::format('png')
                                ->margin(0)
                                ->size(220)            
                                ->encoding('UTF-8')         
                                ->errorCorrection('Q')
                                ->generate($leer_respuesta['cadena_para_codigo_qr'], $this->pathQr . $fileName . '.png');

                        if (file_exists($nombre)) {
                            $venta->qr = $fileName .'.png';
                            Log::info('Almacenado ' . $nombre);
                        }
                    }

                    $venta->save();
                } else {
                    if (isset($leer_respuesta['errors'])) {
                        $mensaje = $leer_respuesta['codigo'] . ' - ' .$leer_respuesta['errors'];
                    } else {
                        $mensaje = 'Error en envio a Proveedor de Servicios Electrónicos';
                    }
                    return $this->errorResponse($mensaje, 422); 
                }
            }
            
            $venta = Venta::select('idventa', 'qr', 'hash', 'pdfformato')->findOrFail($idventa); 
        }

        if (empty($venta->qr)) {
            return $this->errorResponse("Comprobante no tiene caracteres QR", 422);
        }

        if (empty($venta->hash)) {
            return $this->errorResponse('Comprobante no tiene caracteres HASH', 422); 
        }

        
        if ($request->filled('pdfformato')) {
            $formato = $request->pdfformato;
        }
            
        $leer_respuesta = $this->generarPDF($venta->idventa, $formato);
        Log::info($leer_respuesta);

        if (!$leer_respuesta['codigo']) {
            return $this->errorResponse($leer_respuesta['mensaje'] , 422);
        }
        
        return $this->showMessage($leer_respuesta['mensaje'] .'z'); 
    }

    public function estadoComprobante(Request $request, $idventa) {
 
        $venta = Venta::select('idventa', 'sunat_aceptado')->findOrFail($idventa); 
        
        if ($venta->sunat_aceptado === '1') {
            return $this->showMessage('Comprobante ya se encuentra aceptado en [PSE]'); 
        }

        // Consultar a PSE
        $leer_respuesta = $this->consultarEmision($venta->idventa);

        if (isset($leer_respuesta['aceptada_por_sunat']) && !isset($leer_respuesta['errors'])) {                 
            if ($leer_respuesta['aceptada_por_sunat'] === TRUE) {
                $venta->sunat_aceptado = '1';
                $venta->save();
            } else {
                return $this->errorResponse("Comprobante pendiente de aceptación en [PSE]", 422);
            } 
        } else {
            if (isset($leer_respuesta['errors'])) {
                $mensaje = $leer_respuesta['codigo'] . ' - ' .$leer_respuesta['errors'];
            } else {
                $mensaje = 'Error en envio a Proveedor de Servicios Electrónicos';
            }
            return $this->errorResponse($mensaje, 422);
        }
        
        return $this->showMessage('Se actualizó emisión de comprobante desde [PSE]'); 
    }

    public function estadoAnulacion(Request $request, $idventa) {

        $venta = Venta::select('idventa', 'sunat_anulado_aceptado')->findOrFail($idventa); 
        
        if ($venta->sunat_anulado_aceptado === '1') {
            return $this->showMessage('Comprobante ya se encuentra anulado en [PSE]'); 
        } 

        DB::beginTransaction(); 
        try {

            // Consultar a PSE
            $leer_respuesta = $this->consultarAnulacion($venta->idventa);

            if (isset($leer_respuesta['aceptada_por_sunat']) && !isset($leer_respuesta['errors'])) {                 
                if ($leer_respuesta['aceptada_por_sunat'] === TRUE) {
                    $venta->sunat_anulado_aceptado = '1';
                    $venta->save();
                } else {
                    return $this->errorResponse("Comprobante pendiente de anulación en [PSE]", 422);
                } 
            } else {
                if (isset($leer_respuesta['errors'])) {
                    $mensaje = $leer_respuesta['codigo'] . ' - ' .$leer_respuesta['errors'];
                } else {
                    $mensaje = 'Error en envio a Proveedor de Servicios Electrónicos';
                }
                return $this->errorResponse($mensaje, 422);
            } 
        } catch (QueryException $e) {
            DB::rollback();
        }

        DB::commit();
        
        return $this->showMessage('Se actualizó anulación de comprobante desde [PSE]');  
    }

    public function correoEnvio(Request $request, $idventa){
        
        $venta = Venta::with(
            'empresa:idempresa,ruc,razonsocial',
            'docnegocio:iddocumentofiscal,nombre,codigosunat'
        )->findOrFail($idventa); 
        // return $this->showOne($venta);  
        // return $this->showMessage($venta);    

        $fileName = $venta->empresa->ruc . '-' . 
                    $venta->docnegocio->codigosunat . '-' . 
                    $venta->serie . '-' . 
                    $venta->numero;

        $filePDF = $this->pathPdf . $fileName . '.pdf';
        $fileXML = $this->pathXml . $fileName . '.xml'; 
        $fileCDR = $venta->cdr ? $this->pathCdr . $fileName . '.xml' : NULL;

        if (!file_exists($filePDF)) { 
            return $this->errorResponse('PDF no existe. Comunicarse con proveedor.' , 422); 
        }

        if (!file_exists($fileXML)) {
            return $this->errorResponse('XML no existe. Comunicarse con proveedor.', 422);
        }

        if (!empty($fileCDR) && !file_exists($fileCDR)) {
            return $this->errorResponse('CDR no existe. Comunicarse con proveedor.', 422);
        }
   
        if (empty($request->cpecorreo)) {       
            \Log::info('Se atasco');      
            return $this->errorResponse('Correo inválido', 422);
        } 

        try{
            // for ($i=0; $i < 20; $i++) { 
            \Log::info(print_r(date('H:i:s') . ' inicio.', true)); 
            $return = Mail::to($request->cpecorreo)->send(new InvoiceSend($venta, $filePDF, $fileXML, $fileCDR));  
            \Log::info(print_r(date('H:i:s') . ' fin ' . $request->cpecorreo, true)); 
            // }  
            $venta->sendcorreo = '1';
            $venta->save();
        } 
        catch(\Exception $e){            
            \Log::info(print_r($e->getMessage(), true)); 
            return $this->errorResponse('Algo anda mal', 422);
        }
        
        return $this->showMessage('Enviado a ' . $request->cpecorreo);
    }

    public function enviarCorreo($idventa) {

        $venta = Venta::select('idempresa', 'iddocumentofiscal', 'serie', 'numero', 'cpecorreo', 'pdf', 'xml', 'cdr')
                    ->with(
                        'empresa:idempresa,ruc,razonsocial', 
                        'docnegocio:iddocumentofiscal,nombre,codigosunat')
                    ->find($idventa);

        $fileName = $venta->empresa->ruc . '-' . 
                    $venta->docnegocio->codigosunat . '-' . 
                    $venta->serie . '-' . 
                    $venta->numero;

        $filePDF = $this->pathPdf . $fileName . '.pdf';
        $fileXML = $this->pathXml . $fileName . '.xml';
        $fileCDR = $venta->cdr ? ($this->pathCdr . 'CDR_' . $fileName . '.xml') : null;

        if (!file_exists($filePDF)) {  
            return array('codigo' => false, 'mensaje' => 'PDF no existe');
        }

        if (!file_exists($fileXML)) {
            return array('codigo' => false, 'mensaje' => 'XML no existe');
        }

        if ($venta->iddocumentofiscal === 1 && !file_exists($fileCDR)) {
            return array('codigo' => false, 'mensaje' => 'CDR no existe');
        }
   
        if (empty($venta->cpecorreo)) {        
            return array('codigo' => false, 'mensaje' => 'Correo no existe');
        } 

        try{
            \Log::info(print_r(date('H:i:s') . ' inicio.', true)); 
            $return = Mail::to($venta->cpecorreo)->send(new InvoiceSend($venta, $filePDF, $fileXML, $fileCDR));  
            \Log::info(print_r(date('H:i:s') . ' fin ' . $venta->cpecorreo, true)); 

            $venta->sendcorreo = '1'; 
            $venta->save();

            $data = array('codigo' => true, 'mensaje' => 'Enviado a ' . $venta->cpecorreo);
        } 
        catch(\Exception $e){            
            \Log::info(print_r($e->getMessage(), true)); 

            $data = array('codigo' => false, 'mensaje' => 'Sucedió una Excepción');
        }
        
        return $data;
    } 

    /*  Métodos de PSE Nubefact / Bizlinks
        - emitirComprobante()
        - consultarEmision()
        - anularComprobante()
        - consultarAnulacion()
    */
    public function emitirComprobante($idventa) {

        $venta = Venta::with([
            'empresa:idempresa,ruc', 
            'docnegocio:iddocumentofiscal,codigopse,codigosunat', 
            'sede:idsede,pseurl,psetoken', 
            'ventadet:idventa,nombre,descripcion,unidadmedida,codigo,cantidad,valorunit,preciounit,valorventa,idimpuesto,montototalimpuestos,total,codigosunat',
            'money:idmoneda,codigopse'])->findOrFail($idventa);  

        switch ($venta->clientedoc) {
            case 1:
                $clientedoc = '1'; // DNI
                break;
            case 2:
                $clientedoc = '6'; // RUC
                break;
            case 3:
                $clientedoc = '7'; // PASAPORTE
                break;
            case 4:
                $clientedoc = '4'; // CARNET DE EXTRANJERIA
                break;
            case 5:
                $clientedoc = '-'; // VARIOS - VENTAS MENORES A S/.700.00 Y OTROS
                break;
            case 6:
                $clientedoc = '0'; // NO DOMICILIADO, SIN RUC (EXPORTACIÓN)
                break;
            case 7:
                $clientedoc = 'A'; // CÉDULA DIPLOMÁTICA DE IDENTIDAD
                break;
        }

        // 1. Formatear
        $data = array( 
            "operacion"                         => "generar_comprobante",
            "tipo_de_comprobante"               => $venta->docnegocio->codigopse,
            "serie"                             => $venta->serie,
            "numero"                            => $venta->numero,
            "sunat_transaction"                 => $venta->operacion,
            "cliente_tipo_de_documento"         => $clientedoc,
            "cliente_numero_de_documento"       => $venta->clientenumerodoc,
            "cliente_denominacion"              => $venta->clientenombre,
            "cliente_direccion"                 => $venta->clientedireccion,
            "cliente_email"                     => $venta->cpecorreo,
            "cliente_email_1"                   => "",
            "cliente_email_2"                   => "",
            "fecha_de_emision"                  => $venta->fechaemision,
            "fecha_de_vencimiento"              => $venta->fechavencimiento,
            "moneda"                            => $venta->money->codigopse,
            "tipo_de_cambio"                    => $venta->tipocambio,
            "porcentaje_de_igv"                 => number_format($venta->igv, 2), 
            "descuento_global"                  => "",
            "total_descuento"                   => "",
            "total_anticipo"                    => "",
            "total_gravada"                     => number_format($venta->gravada, 2),
            "total_inafecta"                    => number_format($venta->inafecta, 2),
            "total_exonerada"                   => number_format($venta->exonerada, 2),
            "total_igv"                         => number_format($venta->valorimpuesto, 2),
            "total_gratuita"                    => number_format($venta->gratuita, 2),
            "total_otros_cargos"                => number_format($venta->cargo, 2),
            "total"                             => number_format($venta->total, 2),
            "percepcion_tipo"                   => "",
            "percepcion_base_imponible"         => "",
            "total_percepcion"                  => "",
            "total_incluido_percepcion"         => "",
            "detraccion"                        => $venta->detraccion === '1' ? 'true' : 'false',
            "observaciones"                     => $venta->observacion,
            "documento_que_se_modifica_tipo"    => $venta->documentonc,
            "documento_que_se_modifica_serie"   => $venta->serienc,
            "documento_que_se_modifica_numero"  => $venta->numeronc,
            "tipo_de_nota_de_credito"           => $venta->tiponc,
            "tipo_de_nota_de_debito"            => "",
            "enviar_automaticamente_a_la_sunat" => "true",
            "enviar_automaticamente_al_cliente" => "false",
            "codigo_unico"                      => $venta->idventa,
            "condiciones_de_pago"               => $venta->condicionpago,
            "medio_de_pago"                     => "",
            "placa_vehiculo"                    => $venta->placavehiculo,
            "orden_compra_servicio"             => $venta->ordencompra, 
            "formato_de_pdf"                    => $venta->pdfformato,
            "items" => array()
        );

        foreach ($venta->ventadet as $row) { 

            $nombreproducto = $row->nombre;

            if(!empty($row->descripcion)) {
                $nombreproducto .= ' ' . $row->descripcion;
            }

            $data["items"][] = array(
                "unidad_de_medida"          => $row->unidadmedida,
                "codigo"                    => $row->codigo,
                "descripcion"               => $nombreproducto,
                "cantidad"                  => number_format($row->cantidad, 2),
                "valor_unitario"            => number_format($row->valorunit, 3),
                "precio_unitario"           => number_format($row->preciounit, 3),
                "descuento"                 => "",
                "subtotal"                  => number_format($row->valorventa, 2),
                "tipo_de_igv"               => $row->idimpuesto,
                "igv"                       => number_format($row->montototalimpuestos, 2),
                "total"                     => number_format($row->total, 2),
                "anticipo_regularizacion"   => "false",
                "anticipo_documento_serie"  => "",
                "anticipo_documento_numero" => "",
                "codigo_producto_sunat"     => $row->codigosunat,
            );
        }

        // \Log::info($data);
        $data_json = json_encode($data); 

        Log::info('Por enviar a [PSE]');
        Log::info($venta->sede->psetoken);
        Log::info($venta->sede->pseurl);
        // 2. Enviar           
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $venta->sede->pseurl);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$venta->sede->psetoken.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);
        Log::info($respuesta);
        // 3.Leer respuesta
        $leer_respuesta = json_decode($respuesta, true);
        Log::info($leer_respuesta);

        $fileName = $venta->empresa->ruc . '-' . 
                        $venta->docnegocio->codigosunat . '-' . 
                        $venta->serie . '-' . 
                        $venta->numero;

        if (isset($leer_respuesta['aceptada_por_sunat']) && !isset($leer_respuesta['errors'])) { 
            // Log::info($leer_respuesta);
            if (strlen($leer_respuesta['sunat_soap_error']) > 50) { // Capturar error propios de SUNAT
                $leer_respuesta['sunat_soap_error'] = substr($leer_respuesta['sunat_soap_error'], 0, 50);
            }

            $venta->sunat_aceptado = $leer_respuesta['aceptada_por_sunat'] === TRUE ? '1' : '0';
            $venta->sunat_nota = $leer_respuesta['sunat_description'];
            $venta->sunat_nota .= '|' . $leer_respuesta['sunat_note'];
            $venta->sunat_nota .= '|' . $leer_respuesta['sunat_responsecode'];
            $venta->sunat_nota .= '|' . $leer_respuesta['sunat_soap_error'];
            $venta->hash = $leer_respuesta['codigo_hash'];
            $venta->enlace = $leer_respuesta['enlace_del_pdf'];

            // Almacenar XML
            if (isset($leer_respuesta['enlace_del_xml']) && !empty($leer_respuesta['enlace_del_xml'])) {
                $nombre = $this->pathXml . $fileName . '.xml';
                file_put_contents($nombre, fopen($leer_respuesta['enlace_del_xml'], 'r')); 

                if (file_exists($nombre)) {
                    $venta->xml = $fileName .'.xml';
                }
            }

            // Almacenar CDR
            if (isset($leer_respuesta['enlace_del_cdr']) && !empty($leer_respuesta['enlace_del_cdr'])) {
                Log::info('Por almacenar CDR');
                $nombre = $this->pathCdr . 'CDR_' . $fileName . '.xml';
                file_put_contents($nombre, fopen($leer_respuesta['enlace_del_cdr'], 'r'));
                
                if (file_exists($nombre)) {
                    $venta->cdr = 'CDR_' . $fileName .'.xml';
                    Log::info('Almacenado ' . $nombre);
                }
            }

            // Almacenar Imagen QR
            if (isset($leer_respuesta['cadena_para_codigo_qr']) && !empty($leer_respuesta['cadena_para_codigo_qr'])) {
                $nombre = $this->pathQr . $fileName . '.png';

                QrCode::format('png')
                        ->margin(0)
                        ->size(220)            
                        ->encoding('UTF-8')         
                        ->errorCorrection('Q')
                        ->generate($leer_respuesta['cadena_para_codigo_qr'], $this->pathQr . $fileName . '.png');

                if (file_exists($nombre)) {
                    $venta->qr = $fileName .'.png';
                }
            }

            $venta->save();

            $return = array('codigo' => true, 'mensaje' => $leer_respuesta['aceptada_por_sunat']);
        } else {
            if (isset($leer_respuesta['errors'])) {
                $mensaje = $leer_respuesta['codigo'] . ' - ' .$leer_respuesta['errors'] . '(' .$fileName . ')';
            } else {
                $mensaje = 'Error en envio a PSE';
            }

            $return = array('codigo' => false, 'mensaje' => $mensaje); 
        }

        return $return;
    }

    public function emitirComprobanteLocal($idventa) {

        $venta = Venta::select(['idventa', 'idempresa', 'iddocumentofiscal', 'idsede', 'serie', 'numero', 'valorimpuesto', 'total', 
                                'fechaemision', 'clientedoc', 'clientenumerodoc'])
                        ->with(['empresa:idempresa,ruc', 
                                'docnegocio:iddocumentofiscal,codigopse,codigosunat', 
                                'sede:idsede,pseurl,psetoken', 
                                'ventadet:idventa,nombre,descripcion,unidadmedida,codigo,cantidad,valorunit,preciounit,valorventa,idimpuesto,montototalimpuestos,total,codigosunat',
                                'money:idmoneda,codigopse'])
                        ->findOrFail($idventa);

        switch ($venta->clientedoc) {
            case 1:
                $clientedoc = '1'; // DNI
                break;
            case 2:
                $clientedoc = '6'; // RUC
                break;
            case 3:
                $clientedoc = '7'; // PASAPORTE
                break;
            case 4:
                $clientedoc = '4'; // CARNET DE EXTRANJERIA
                break;
            case 5:
                $clientedoc = '-'; // VARIOS - VENTAS MENORES A S/.700.00 Y OTROS
                break;
            case 6:
                $clientedoc = '0'; // NO DOMICILIADO, SIN RUC (EXPORTACIÓN)
                break;
            case 7:
                $clientedoc = 'A'; // CÉDULA DIPLOMÁTICA DE IDENTIDAD
                break;
        }
        
        // A. Número de RUC del emisor electrónico.
        // B. Tipo de comprobante de pago electrónico.
        // C. Numeración conformada por serie y número correlativo.
        // D. Sumatoria IGV, de ser el caso.
        // E. Importe total de la venta, cesión en uso o servicio prestado.
        // F. Fecha de emisión.
        // G. Tipo de documento del adquirente o usuario, de ser el caso.
        // H. Número de documento del adquirente o usuario, de ser el caso.

        $codigo_hash = 'Loremipsum';
        $cadena_para_codigo_qr = $venta->empresa->ruc . '|' .
                                 $venta->docnegocio->codigosunat . '|' .
                                 $venta->serie . '|' .
                                 $venta->numero . '|' .
                                 $venta->valorimpuesto . '|' .
                                 $venta->total . '|' .
                                 $venta->fechaemision . '|' .
                                 $venta->clientedoc . '|' .
                                 $venta->clientenumerodoc . '|' .
                                 $codigo_hash;
 
        $fileName = $venta->empresa->ruc . '-' . 
                    $venta->docnegocio->codigosunat . '-' . 
                    $venta->serie . '-' . 
                    $venta->numero;

        // Almacenar XML
        $nombre = $this->pathXml . $fileName . '.xml';

        \Log::info(print_r($nombre, true));  
        file_put_contents($nombre, 'Esto es el codigo del archivo XML'); 

        $genXML = false;
        if (file_exists($nombre)) {
            $venta->xml = $fileName .'.xml';
            $genXML = true;
        }

        // Almacenar Imagen QR
        $nombre = $this->pathQr . $fileName . '.png';        
        \Log::info(print_r($nombre, true));  
        QrCode::format('png')
                ->margin(0)
                ->size(220)            
                ->encoding('UTF-8')         
                ->errorCorrection('Q')
                ->generate($cadena_para_codigo_qr, $this->pathQr . $fileName . '.png');

        $genQR = false;
        if (file_exists($nombre)) {
            $venta->qr = $fileName .'.png';
            $genQR = true;
        }

        if ($genXML && $genQR) {
            $venta->save();
            $return = array('codigo' => true, 'mensaje' => 'QR y XML guardado');
        } else {
            $return = array('codigo' => false, 'mensaje' => 'QR y XML no se guardó');
        }

        return $return;
    }

    private function consultarEmision($idventa) {

        $venta = Venta::with(['docnegocio:iddocumentofiscal,codigopse', 'sede:idsede,pseurl,psetoken'])->findOrFail($idventa);

        // 1. Formatear JSON
        $data = array( 
            "operacion"            => "consultar_comprobante",
            "tipo_de_comprobante"  => $venta->docnegocio->codigopse,
            "serie"                => $venta->serie,
            "numero"               => $venta->numero
        ); 
 
        $data_json = json_encode($data); 

        // 2. Enviar PSE  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $venta->sede->pseurl);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$venta->sede->psetoken.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        // 3. Leer respuesta
        $leer_respuesta = json_decode($respuesta, true);
        
        return $leer_respuesta;
    }

    private function anularComprobante($idventa) {    
  
        $venta = Venta::with(['docnegocio:iddocumentofiscal,codigopse', 'sede:idsede,pseurl,psetoken'])->findOrFail($idventa);

        // 1. Formatear JSON
        $data = array(
            "operacion"            => "generar_anulacion",
            "tipo_de_comprobante"  => $venta->docnegocio->codigopse,
            "serie"                => $venta->serie,
            "numero"               => $venta->numero,
            "motivo"               => $venta->motivoanulacion ? $venta->motivoanulacion : "ERROR DE EMISIÓN",
            "codigo_unico"         => $venta->idventa
        );   

        $data_json = json_encode($data);

        // 2. Enviar PSE  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $venta->sede->pseurl);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$venta->sede->psetoken.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        // 3.Leer resouesta
        $leer_respuesta = json_decode($respuesta, true);
        
        return $leer_respuesta;
    }

    private function consultarAnulacion($idventa) {

        $venta = Venta::with(['docnegocio:iddocumentofiscal,codigopse', 'sede:idsede,pseurl,psetoken'])->findOrFail($idventa);

        // 1. Formatear JSON
        $data = array( 
            "operacion"            => "consultar_anulacion",
            "tipo_de_comprobante"  => $venta->docnegocio->codigopse,
            "serie"                => $venta->serie,
            "numero"               => $venta->numero
        ); 
        
        $data_json = json_encode($data); 
        \Log::info($data_json); 

        \Log::info($venta->sede->pseurl); 
        \Log::info($venta->sede->psetoken); 

        // 2. Enviar PSE  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $venta->sede->pseurl);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$venta->sede->psetoken.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        // 3. Leer respuesta
        $leer_respuesta = json_decode($respuesta, true);
        
        return $leer_respuesta;
    }

    
}
