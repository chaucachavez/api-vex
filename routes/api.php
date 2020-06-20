<?php

use App\Models\Sede;
use App\Models\User;
use App\Models\Venta;
use App\Models\Masivo;
use App\Models\Moneda;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Citamedica;
use Illuminate\Http\Request;
use App\Models\Documentoserie;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Pdfs\invoiceA4Controller;
use App\Http\Controllers\Pdfs\invoiceTICKETController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| 
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/ 
 
Route::get('invoicea4/{idventa}', 'Pdfs\invoiceA4Controller@reporte');
Route::get('invoicea5/{idventa}', 'Pdfs\invoiceA5Controller@reporte');
Route::get('masivox/{id}', 'Pdfs\invoiceMASIVOController@reporte');

Route::middleware('jwt')->get('directorios', function (Request $request) { 

    // DB::enableQueryLog();
    // Entidad::find(1);
    // $newToken = auth()->refresh();
    auth()->claims(['foo' => 'bar']);
    $payload = auth()->payload();
    dd($payload->toArray());

    // dd(DB::getQueryLog());

    dd(Storage::disk('publica')->url('empresa/31/img/logo_cuadrado.png'));
    dd(public_path());


    Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/img');
    Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/pdf');
    Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/xml');
    Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/cdr');
    Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/qr');
    Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/pdf-masivo');
});

Route::resource('productos.categorias', 'Producto\ProductoCategoriaController', ['only' => ['index', 'update', 'destroy']]);
Route::resource('ventadetalles.categorias', 'Ventadet\VentadetCategoriaController', ['only' => ['index']]);
Route::resource('medicos', 'Medico\MedicoController', ['only' => ['index', 'show']]);
Route::resource('medicos.clientes', 'Medico\MedicoClienteController', ['only' => ['index']]);
Route::resource('clientes.citasmedicas', 'Cliente\ClienteCitamedicaController', ['only' => ['index']]);
Route::resource('clientes.productos', 'Cliente\ClienteProductoController', ['only' => ['index']]);
Route::resource('categorias.productos', 'Categoria\CategoriaProductoController', ['only' => ['index']]);
Route::resource('categorias.tratamientos', 'Categoria\CategoriaTratamientoController', ['only' => ['index']]);
Route::resource('clientes.medicos.citasmedicas', 'Cliente\ClienteMedicoCitamedicaController', ['only' => ['store']]);
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

/**/
Route::resource('anexos', 'Anexo\AnexoController', ['except' => ['create', 'edit']]);
Route::resource('anos', 'Ano\AnoController', ['except' => ['create', 'edit']]);
Route::resource('aperturas', 'Apertura\AperturaController', ['except' => ['create', 'edit']]);
Route::resource('asistencias', 'Asistencia\AsistenciaController', ['except' => ['create', 'edit']]);
Route::resource('autorizaciones', 'Autorizacion\AutorizacionController', ['except' => ['create', 'edit']]);
Route::resource('cajas', 'Caja\CajaController', ['except' => ['create', 'edit']]);
Route::resource('cajachicas', 'Cajachica\CajachicaController', ['except' => ['create', 'edit']]);
Route::resource('camillas', 'Camilla\CamillaController', ['except' => ['create', 'edit']]);
Route::resource('categorias', 'Categoria\CategoriaController', ['except' => ['create', 'edit']]);
Route::resource('ciclos', 'Ciclo\CicloController', ['except' => ['create', 'edit']]);
Route::resource('ciclodetalles', 'Ciclodet\CiclodetController', ['except' => ['create', 'edit']]);
Route::resource('citamedicas', 'Citamedica\CitamedicaController', ['except' => ['create', 'edit']]);
Route::resource('citaterapeutas', 'Citaterapeuta\CitaterapeutaController', ['except' => ['create', 'edit']]);
Route::resource('consultorios', 'Consultorio\ConsultorioController', ['except' => ['create', 'edit']]);
Route::resource('cupones', 'Cupon\CuponController', ['except' => ['create', 'edit']]); 
Route::resource('diagnosticos', 'Diagnostico\DiagnosticoController', ['except' => ['create', 'edit']]);
Route::resource('docnegocios', 'Docnegocio\DocnegocioController', ['except' => ['create', 'edit']]);
Route::resource('documentoseries', 'Documentoserie\DocumentoserieController', ['except' => ['create', 'edit']]);
Route::resource('empresas', 'Empresa\EmpresaController', ['except' => ['create', 'edit']]);
Route::resource('especialidades', 'Especialidad\EspecialidadController', ['except' => ['create', 'edit']]);
Route::resource('examenes', 'Examen\ExamenController', ['except' => ['create', 'edit']]);
Route::resource('facturas', 'Factura\FacturaController', ['except' => ['create', 'edit']]);
Route::resource('historias', 'Historia\HistoriaController', ['except' => ['create', 'edit']]);
Route::resource('horarios', 'Horario\HorarioController', ['except' => ['create', 'edit']]);
Route::resource('ips', 'Ip\IpController', ['except' => ['create', 'edit']]);
Route::resource('llamadas', 'Llamada\LlamadaController', ['except' => ['create', 'edit']]);
Route::resource('llamadadetalles', 'Llamadadet\LlamadadetController', ['except' => ['create', 'edit']]);
Route::resource('logaccesos', 'Logacceso\LogaccesoController', ['except' => ['create', 'edit']]);
Route::resource('mediospago', 'Mediopago\MediopagoController', ['except' => ['create', 'edit']]);
Route::resource('metas', 'Meta\MetaController', ['except' => ['create', 'edit']]);
Route::resource('modelos', 'Modelo\ModeloController', ['except' => ['create', 'edit']]);
Route::resource('modelodetalles', 'Modelodet\ModelodetController', ['except' => ['create', 'edit']]);
Route::resource('modulos', 'Modulo\ModuloController', ['except' => ['create', 'edit']]);
Route::resource('monedas', 'Moneda\MonedaController', ['except' => ['create', 'edit']]);
Route::resource('notascredito', 'Notacredito\NotacreditoController', ['except' => ['create', 'edit']]);
Route::resource('ordenes', 'Orden\OrdenController', ['except' => ['create', 'edit']]);
Route::resource('ordendetalles', 'Ordendet\OrdendetController', ['except' => ['create', 'edit']]);
Route::resource('pagos', 'Pago\PagoController', ['except' => ['create', 'edit']]);
Route::resource('paseslibres', 'Paselibre\PaselibreController', ['except' => ['create', 'edit']]);
Route::resource('perfiles', 'Perfil\PerfilController', ['except' => ['create', 'edit']]);
Route::resource('productos', 'Producto\ProductoController', ['except' => ['create', 'edit']]);
Route::resource('referencias', 'Referencia\ReferenciaController', ['except' => ['create', 'edit']]);
Route::resource('reservaciones', 'Reservacion\ReservacionController', ['except' => ['create', 'edit']]);
Route::resource('saldos', 'Saldo\SaldoController', ['except' => ['create', 'edit']]);
Route::resource('sedes', 'Sede\SedeController', ['except' => ['create', 'edit']]);
Route::resource('sedehorarios', 'Sede\SedehorarioController', ['except' => ['create', 'edit']]);
Route::resource('seguros', 'Seguro\SeguroController', ['except' => ['create', 'edit']]);
Route::resource('segurosplanes', 'Aseguradoraplan\AseguradoraplanController', ['except' => ['create', 'edit']]);
Route::resource('servicios', 'Servicio\ServicioController', ['except' => ['create', 'edit']]);
Route::resource('superperfiles', 'Superperfil\SuperperfilController', ['except' => ['create', 'edit']]);
Route::resource('tarifas', 'Tarifa\TarifaController', ['except' => ['create', 'edit']]);
Route::resource('tarifarios', 'Tarifario\TarifarioController', ['except' => ['create', 'edit']]);
Route::resource('terapias', 'Terapia\TerapiaController', ['except' => ['create', 'edit']]);
Route::resource('terapiadetalles', 'Terapiadet\TerapiadetController', ['except' => ['create', 'edit']]);
Route::resource('timbrados', 'Timbrado\TimbradoController', ['except' => ['create', 'edit']]);
Route::resource('tipoautorizaciones', 'Tipoautorizacion\TipoautorizacionController', ['except' => ['create', 'edit']]);
Route::resource('tratamientos', 'Tratamiento\TratamientoController', ['except' => ['create', 'edit']]);
Route::resource('ubigeos', 'Ubigeo\UbigeoController', ['except' => ['create', 'edit']]);
Route::resource('unidades', 'Unidad\UnidadController', ['except' => ['create', 'edit']]);
Route::resource('departamentos', 'Ubigeo\DepartamentoController', ['except' => ['create', 'edit']]);
Route::resource('provincias', 'Ubigeo\ProvinciaController', ['except' => ['create', 'edit']]);
Route::resource('distritos', 'Ubigeo\DistritoController', ['except' => ['create', 'edit']]);
Route::resource('catalogos', 'Catalogo\CatalogoController', ['except' => ['create', 'edit']]);
Route::resource('entidades', 'Entidad\EntidadController', ['except' => ['create', 'edit']]);
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('masivos', 'Masivo\MasivoController', ['except' => ['create', 'edit']]);

Route::get('empresa/usuarios', 'Empresa\EmpresaUsersController@index');

Route::resource('ventas', 'Venta\VentaController', ['except' => ['create', 'edit']]);
Route::resource('ventadetalles', 'Ventadet\VentadetController', ['except' => ['create', 'edit']]);

Route::resource('documentos', 'Documento\DocumentoController', ['except' => ['create', 'edit']]);
Route::resource('horas', 'Hora\HoraController', ['except' => ['create', 'edit']]);
Route::resource('cargos', 'Cargoorg\CargoorgController', ['except' => ['create', 'edit']]);

Route::resource('diasferiados', 'Diaferiado\DiaferiadoController', ['except' => ['create', 'edit']]);
Route::resource('diasxhoras', 'Diaxhora\DiaxhoraController', ['except' => ['create', 'edit']]);

Route::resource('estados', 'Estadodocumento\EstadodocumentoController', ['except' => ['create', 'edit']]);

Route::get('paises/{pais}/departamentos', 'Ubigeo\UbigeoController@departamentos');
Route::get('paises/{pais}/departamentos/{iddepartamento}/provincias', 'Ubigeo\UbigeoController@provincias');
Route::get('paises/{pais}/departamentos/{iddepartamento}/provincias/{idprovincia}/distritos', 'Ubigeo\UbigeoController@distritos');

// Route::middleware('cors')->post('/authenticate', 'Entidad\EntidadController@authenticate'); 
Route::post('/users/subirimagen/perfil', 'User\UserController@updateImagenPerfil'); 
Route::post('/entidades/subirimagen/{usuario}', 'Entidad\EntidadController@updateimagen'); 

Route::get('citamedicas/{sede}/disponibilidad', 'Citamedica\CitamedicaController@disponibilidad');
Route::get('citaterapeutas/{sede}/disponibilidad', 'Citaterapeuta\CitaterapeutaController@disponibilidad');

Route::post('ventas/export/excel', 'Venta\VentaController@exportExcel');
Route::get('ventas/export/excel', 'Venta\VentaController@exportExcel'); 
Route::post('ventas/export/pdf', 'Venta\VentaController@exportPdf');
Route::get('ventas/export/pdf', 'Venta\VentaController@exportPdf'); 

Route::get('productos/export/excel', 'Producto\ProductoController@exportExcel');
Route::post('productos/export/excel', 'Producto\ProductoController@exportExcel');
Route::get('productos/import/excel', 'Producto\ProductoController@importExcel');
Route::post('productos/import/excel', 'Producto\ProductoController@importExcel');
Route::get('productos/plantilla/excel', 'Producto\ProductoController@templateExcel');
Route::post('productos/plantilla/excel', 'Producto\ProductoController@templateExcel');

Route::post('ventas/savexml', 'Venta\VentaController@saveXml'); 
Route::post('empresas/subirimagen', 'Empresa\EmpresaController@updateimagen'); 
Route::post('empresas/cargardata/{empresa}', 'Empresa\EmpresaController@cargarData'); 
Route::get('/empresas/mi/cuenta', 'Empresa\EmpresaController@cuenta'); 
Route::post('productos/subirimagen/{producto}', 'Producto\ProductoController@updateimagen'); 
Route::post('ventas/anular/{venta}', 'Venta\VentaController@anulacion'); 

Route::group(['prefix' => 'kaka'], function () { 
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::post('/authenticate', 'Entidad\EntidadController@authenticate');
Route::post('/empresatoken', 'Entidad\EntidadController@empresaToken'); 
Route::name('verify')->get('users/verify/{token}', 'Entidad\EntidadController@verify');
Route::post('/users/forgot', 'Entidad\EntidadController@forgotPassword'); 
Route::get('/users/me/{token}', 'Entidad\EntidadController@me');
Route::post('/users/me/{token}/update', 'Entidad\EntidadController@meUpdate'); 
Route::post('/users/reset/{token}', 'Entidad\EntidadController@resetPassword'); 
Route::post('/logouta', 'Entidad\EntidadController@logout'); 
Route::post('/consulta/dniruc', 'Empresa\EmpresaController@consultaDniRuc'); 

Route::get('/hola', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {	
    $user = Entidad::where('identidad', 1)->first(); 
    // dd($user);
    // $user->password = Hash::make($user->password);
    // $user->password = bcrypt($user->password);
    // $user->save();         
    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 18);
    $fpdf->Cell(0, 10, $user->entidad, '1');
    $fpdf->ln();
    $fpdf->Cell(0, 10, $user->idempresa);
    $fpdf->Output();
    exit;
});

Route::get('ventas/regenerar-pdf/{idventa}', 'Venta\VentaController@regenerarPdf');
Route::get('ventas/estado-comprobante/{idventa}', 'Venta\VentaController@estadoComprobante');
Route::get('ventas/estado-anulacion/{idventa}', 'Venta\VentaController@estadoAnulacion');
Route::post('ventas/correo-envio/{idventa}', 'Venta\VentaController@correoEnvio');
Route::get('unidades/unidad-medida/empresa', 'Unidad\UnidadController@unidadesEmpresa');
Route::get('modulos/empresa/lista', 'Modulo\ModuloController@modulosEmpresa');

Route::post('masivos/anular/{masivo}', 'Masivo\MasivoController@anular');

Route::get('soapws', 'Empresa\EmpresaController@soapws');

Route::get('/ws', function (Request $request) { 

    // $client = new SoapClient("https://testing.bizlinks.com.pe/integrador21/ws/invoker?wsdl");
    // $functions = $client->__getFunctions(); //Obtiene las funciones disponibles en el servicio
    // var_dump ('<pre>', $functions); 
    // exit;

    // $url = "https://testing.bizlinks.com.pe/integrador21/ws/invoker?wsdl";
    // $client = new SoapClient($url); 
    // $userid = "JULIOCHAUCA";
    // $password = "10441200264";  

    // $client->__setSoapHeaders($this->soapClientWSSecurityHeader($userid, $password));

    // $functions = $client->__getFunctions();
    // var_dump ($functions); 

});

// function soapClientWSSecurityHeader($user, $password)
//     {   
//         // Creating date using yyyy-mm-ddThh:mm:ssZ format
//         $tm_created = gmdate('Y-m-d\TH:i:s\Z');
//         $tm_expires = gmdate('Y-m-d\TH:i:s\Z', gmdate('U') + 180); //only necessary if using the timestamp element

//         // Generating and encoding a random number
//         $simple_nonce = mt_rand();
//         $encoded_nonce = base64_encode($simple_nonce);

//         // Compiling WSS string
//         $passdigest = base64_encode(sha1($simple_nonce . $tm_created . $password, true));

//         // Initializing namespaces
//         $ns_wsse = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
//         $ns_wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
//         $password_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';
//         $encoding_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary';

//         // Creating WSS identification header using SimpleXML
//         $root = new SimpleXMLElement('<root/>');

//         $security = $root->addChild('wsse:Security', null, $ns_wsse);

//         //the timestamp element is not required by all servers
//         $timestamp = $security->addChild('wsu:Timestamp', null, $ns_wsu);
//         $timestamp->addAttribute('wsu:Id', 'Timestamp-28');
//         $timestamp->addChild('wsu:Created', $tm_created, $ns_wsu);
//         $timestamp->addChild('wsu:Expires', $tm_expires, $ns_wsu);

//         $usernameToken = $security->addChild('wsse:UsernameToken', null, $ns_wsse);
//         $usernameToken->addChild('wsse:Username', $user, $ns_wsse);
//         $usernameToken->addChild('wsse:Password', $password, $ns_wsse)->addAttribute('Type', $password_type);
//         $usernameToken->addChild('wsse:Nonce', $encoded_nonce, $ns_wsse)->addAttribute('EncodingType', $encoding_type);
//         $usernameToken->addChild('wsu:Created', $tm_created, $ns_wsu);

//         // Recovering XML value from that object
//         $root->registerXPathNamespace('wsse', $ns_wsse);
//         $full = $root->xpath('/root/wsse:Security');
//         $auth = $full[0]->asXML();

//         return new SoapHeader($ns_wsse, 'Security', new SoapVar($auth, XSD_ANYXML), true);
//     }

Route::get('/invoice/{id}', function (Request $request, $id) { 

    // $venta = Venta::select('idventa', 'sunat_aceptado', 'idempresa', 'iddocumentofiscal')
    // ->with(
    //     'empresa:idempresa,ruc',
    //     'docnegocio:iddocumentofiscal,codigosunat'
    // )
    // ->findOrFail($id);  
    // dd($venta); 

    //  QrCode::format('png')            
    //         ->size(220)   
    //         ->margin(0)         
    //         ->encoding('UTF-8')         
    //         ->errorCorrection('Q')            
    //         ->generate('10441200264|03|B001|000046|1.98|13.00|23/09/2019|1|46833730|mVos3HKbi2FfLhBJhqNrM8A60i7/ogrMkOKnFFQG7co=|','qr/46.png');

    // QrCode::format('png')            
    //         ->size(220)   
    //         ->margin(0)         
    //         ->encoding('UTF-8')         
    //         ->errorCorrection('Q')            
    //         ->generate('10441200264|03|B001|000045|2.36|15.50|02/09/2019|1|74310503||','qr/45.png');

    // QrCode::format('png')            
    //         ->size(220)   
    //         ->margin(0)         
    //         ->encoding('UTF-8')         
    //         ->errorCorrection('Q')            
    //         ->generate('10441200264|03|B001|000044|2.67|17.50|02/09/2019|1|74310503||','qr/44.png');

    // QrCode::format('png')            
    //         ->size(220)   
    //         ->margin(0)         
    //         ->encoding('UTF-8')         
    //         ->errorCorrection('Q')            
    //         ->generate('10441200264|01|F001|000030|14.40|94.40|22/10/2019|6|10048208377|HQXP3n08ZfmWHASnR10m+qZ4MvP9MVVTQlG+lOxfbfQ=|','qr/30.png');


    $invoice = new invoiceTICKETController();
    $invoice->reporte($id);
});

Route::get('/create', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {

    $Documentoserie = new Documentoserie;
    // $Documentoserie->idempresa = 10;
    $Documentoserie->idsede = 37;
    $Documentoserie->iddocumentofiscal = 1;
    $Documentoserie->serie = 'F003';
    $Documentoserie->contingencia = '1';
    $Documentoserie->save();

    dd($Documentoserie);
});

Route::get('/crongenerarcomprobante', ['uses' => 'Cronjobs\CronventaController@generarComprobantesMasivos']);
Route::get('/cronenviarcomprobante', ['uses' => 'Cronjobs\CronventaController@enviarComprobantesMasivos']);