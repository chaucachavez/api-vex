<?php

namespace App\Http\Controllers\Empresa;

use SoapVar;
use SoapClient;
use SoapHeader;
use App\Models\Sede;
use App\Models\User;
use App\Models\Venta;
use SimpleXMLElement;
use App\Models\Masivo;
use App\Models\Perfil;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Mail\UserCreated;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends ApiController
{   

    public function __construct() 
    {  
        $this->middleware('jwt', ['except' => ['store']]); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Empresa());
 
        // if (in_array("users", $resource)) {
        //     dd($resource);
        // }

        foreach ($resource as $clave => $valor) {
            if ($valor === "usuarios") {
                $resource[$clave] = "usuarios:idempresa,name,email";
            }
        } 
        // dd($resource);

        //\DB::enableQueryLog();
        $query = Empresa::with($resource)
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

    function soapws(){
        $url = "https://testing.bizlinks.com.pe/integrador21/ws/invoker?wsdl";
        $client = new SoapClient($url); 
        $userid = "JULIOCHAUCA";
        $password = "10441200264";  

        $client->__setSoapHeaders($this->soapClientWSSecurityHeader($userid, $password));

        $functions = $client->__getFunctions();
        dd($functions); 
    }

    function soapClientWSSecurityHeader($user, $password)
    {   
        // Creating date using yyyy-mm-ddThh:mm:ssZ format
        $tm_created = gmdate('Y-m-d\TH:i:s\Z');
        $tm_expires = gmdate('Y-m-d\TH:i:s\Z', gmdate('U') + 180); //only necessary if using the timestamp element

        // Generating and encoding a random number
        $simple_nonce = mt_rand();
        $encoded_nonce = base64_encode($simple_nonce);

        // Compiling WSS string
        $passdigest = base64_encode(sha1($simple_nonce . $tm_created . $password, true));

        // Initializing namespaces
        $ns_wsse = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
        $ns_wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
        $password_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';
        $encoding_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary';

        // Creating WSS identification header using SimpleXML
        $root = new SimpleXMLElement('<root/>');

        $security = $root->addChild('wsse:Security', null, $ns_wsse);

        //the timestamp element is not required by all servers
        $timestamp = $security->addChild('wsu:Timestamp', null, $ns_wsu);
        $timestamp->addAttribute('wsu:Id', 'Timestamp-28');
        $timestamp->addChild('wsu:Created', $tm_created, $ns_wsu);
        $timestamp->addChild('wsu:Expires', $tm_expires, $ns_wsu);

        $usernameToken = $security->addChild('wsse:UsernameToken', null, $ns_wsse);
        $usernameToken->addChild('wsse:Username', $user, $ns_wsse);
        $usernameToken->addChild('wsse:Password', $password, $ns_wsse)->addAttribute('Type', $password_type);
        $usernameToken->addChild('wsse:Nonce', $encoded_nonce, $ns_wsse)->addAttribute('EncodingType', $encoding_type);
        $usernameToken->addChild('wsu:Created', $tm_created, $ns_wsu);

        // Recovering XML value from that object
        $root->registerXPathNamespace('wsse', $ns_wsse);
        $full = $root->xpath('/root/wsse:Security');
        $auth = $full[0]->asXML();

        return new SoapHeader($ns_wsse, 'Security', new SoapVar($auth, XSD_ANYXML), true);
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
            'ruc' => 'required',
            'email' => 'required' ,
            'password' => 'required',
            'celular' => 'required'
        ]; 
 
        $this->validate($request, $reglas);  

        // Validaciones con BD 
        if ($request->filled('email')) { 
            $exists = User::where([
                    'email' => $request->email 
                ])->exists();

            if ($exists)
                return $this->errorResponse($request->email . ' ya existe', 422);
        } 

        if ($request->filled('email')) { 
            $exists = Empresa::where([
                    'ruc' => $request->ruc 
                ])->exists();

            if ($exists)
                return $this->errorResponse($request->ruc . " RUC ya existe", 422);
        } 

        $leer_respuesta = $this->consultarDNIRUC(2, $request->ruc);

        if (empty($leer_respuesta)) {            
            \Log::info(print_r('RUC "'.$request->ruc . '" inválido. Ingrese RUC válido', true));
            return $this->errorResponse('RUC "'.$request->ruc . '" inválido. Ingrese RUC válido', 422);
        }

        $empresa = new Empresa();
        $empresa->nombre = $leer_respuesta['razonSocial'];
        $empresa->razonsocial = $leer_respuesta['razonSocial'];
        $empresa->url = $this->aleatorio(7); 
        $empresa->ambiente = '0'; 
        $empresa->logopdf = 'logo_pdf.png';
        $empresa->logocuadrado = 'logo_cuadrado.png';

        $campos = $request->all();

        $empresa->fill($campos);   
        
        DB::beginTransaction(); 
        try { 

            $empresa->save();

            // Crear directorio empresa
            Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/img');
            Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/pdf');
            Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/xml');
            Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/cdr');
            Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/qr');
            Storage::disk('empresa')->makeDirectory($empresa->idempresa . '/pdf-masivo');

            // Copiar archivos a empresa
            Storage::disk('publica')->copy(
                'img_default/logo_cuadrado.png', 
                'empresa/'.$empresa->idempresa.'/img/logo_cuadrado.png'
            );
            Storage::disk('publica')->copy(
                'img_default/logo_pdf.png', 
                'empresa/'.$empresa->idempresa.'/img/logo_pdf.png'
            );            

            // Table: entidad
            $data = array(
                [
                    'iddocumento' => 2, // RUC
                    'numerodoc' => $request->ruc,
                    'entidad' => $leer_respuesta['razonSocial'],
                    'direccion' => $leer_respuesta['direccion'],
                    'email' => $request->email,
                    'cliente' => '1'
                ],
                [
                    'iddocumento' => 5,  // VARIOS, solo BV
                    'numerodoc' => '-',
                    'apellidopat' => '',
                    'apellidomat' => '',
                    'nombre' => 'VARIOS',
                    'entidad' => 'VARIOS',
                    'direccion' => 'LIMA - PERU',
                    'email' => '',
                    'cliente' => '1'
                ]
            );
            $empresa->entidades()->createMany($data); 

            // Table: producto
            $data = array(
                [
                    'unidadmedida' => 'NIU',
                    'codigo' => 'PRO0001',
                    'nombre' => 'Producto',
                    'moneda' => 'PEN',
                    'costoventa' => '84.75',
                    'valorventa' => '100',
                    'idimpuesto' => 1,
                    'nombre' => 'Producto'
                ],
                [
                    'unidadmedida' => 'ZZ',
                    'codigo' => 'SER0001',
                    'nombre' => 'Servicio',
                    'moneda' => 'PEN',
                    'costoventa' => '84.75',
                    'valorventa' => '100',
                    'idimpuesto' => 1,
                    'nombre' => 'Servicio'
                ]
            );
            $empresa->productos()->createMany($data); 

            // Table: unidadempresa
            $data = array(
                ['codigo' => 'NIU'],
                ['codigo' => 'ZZ'],
                ['codigo' => 'BG'],
                ['codigo' => 'BX'],
                ['codigo' => 'KGM']
            );
            $empresa->medidas()->attach($data);

            // Table: moduloempresa
            $data = array(
                ['idmodulo' => 75],
                ['idmodulo' => 77],
                ['idmodulo' => 79],
                ['idmodulo' => 80],
                ['idmodulo' => 81],
                ['idmodulo' => 82],
                ['idmodulo' => 83],
                ['idmodulo' => 84],
                ['idmodulo' => 86],
                ['idmodulo' => 87],
                ['idmodulo' => 88],
                ['idmodulo' => 89],
                ['idmodulo' => 94],
                ['idmodulo' => 95],
                ['idmodulo' => 96],
                ['idmodulo' => 97],
                ['idmodulo' => 98],
                ['idmodulo' => 99],
                ['idmodulo' => 100]
            );
            $empresa->modulos()->attach($data);

            // Table: sede
            $sede = new Sede;
            $sede->idempresa = $empresa->idempresa; 
            $sede->nombre = 'Local principal'; 
            $sede->direccion = $leer_respuesta['direccion'];
            $sede->departamento = $leer_respuesta['departamento'];
            $sede->provincia = $leer_respuesta['provincia'];
            $sede->distrito = $leer_respuesta['distrito'];            
            $sede->codigosunat = '0000';            
            $sede->pdffactura = 'A4';
            $sede->pdfboleta = 'A4';
            $sede->pdfcolor = '25,8,255'; 
            $sede->comercial = '1';
            $sede->save();

            // Table: documentoserie
            $data = array(
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 2,
                    'numero' => 1,
                    'serie' => 'B001',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'B001',
                ],
                // [
                //     'idempresa' => $empresa->idempresa,
                //     'contingencia' => '0',
                //     'iddocumentofiscal' => 10,
                //     'numero' => 1,
                //     'serie' => 'B001',
                // ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 1,
                    'numero' => 1,
                    'serie' => 'F001',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'F001',
                ],
                // [
                //     'idempresa' => $empresa->idempresa,
                //     'contingencia' => '0',
                //     'iddocumentofiscal' => 10,
                //     'numero' => 1,
                //     'serie' => 'F001',
                // ],
            );
            $sede->comprobantes()->createMany($data); 
            
            // Table: users
            $usuario = new User;
            $usuario->name = $leer_respuesta['razonSocial'];;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->password);
            $usuario->idempresa = $empresa->idempresa;
            $usuario->verified = '0';
            $usuario->acceso = '1';
            $usuario->administrador = '1';
            $usuario->imgperfil = 'profile.jpg';
            $usuario->save();

            $usuario->verification_token = auth()->tokenById($usuario->id);
            $usuario->save();

            // Crear directorio persona
            Storage::disk('persona')->makeDirectory($usuario->id);
            Storage::disk('publica')->copy(
                'img_default/profile.jpg', 
                'persona/'.$usuario->id.'/profile.jpg'
            );

            // Table: modulo_users
            $data = array(                
                ['idmodulo' => 75, 'permiso' => 'E'],                
                ['idmodulo' => 77, 'permiso' => 'E'],                
                ['idmodulo' => 79, 'permiso' => 'E'],
                ['idmodulo' => 80, 'permiso' => 'E'],
                ['idmodulo' => 81, 'permiso' => 'E'],
                ['idmodulo' => 82, 'permiso' => 'E'],
                ['idmodulo' => 83, 'permiso' => 'E'],
                ['idmodulo' => 84, 'permiso' => 'E'],
                ['idmodulo' => 86, 'permiso' => 'E'],
                ['idmodulo' => 87, 'permiso' => 'E'],
                ['idmodulo' => 88, 'permiso' => 'E'],
                ['idmodulo' => 89, 'permiso' => 'E'],
                ['idmodulo' => 94, 'permiso' => 'E'],
                ['idmodulo' => 95, 'permiso' => 'E'],
                ['idmodulo' => 96, 'permiso' => 'E'],
                ['idmodulo' => 97, 'permiso' => 'E'],
                ['idmodulo' => 98, 'permiso' => 'E'],
                ['idmodulo' => 99, 'permiso' => 'E'],
                ['idmodulo' => 100, 'permiso' => 'E']
            ); 
            $usuario->modulos()->attach($data); 

            // Table: sede_users
            $data = array(
                ['idsede' => $sede->idsede]
            );

            $usuario->sedes()->attach($data);

        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($empresa); 
    }

    public function cargarData(Empresa $empresa)
    {         
        $usuario = User::where('idempresa', $empresa->idempresa)->firstOrFail();

        DB::beginTransaction(); 
        try {
            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '10001',
                'nombre' => 'SERVICIOS EXTRAS'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array(
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'ZZ', 'codigo' => '3', 'nombre' => 'ALQUILER DE  LOCAL', 'moneda' => 'PEN', 'valorventa' => '5', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'ZZ', 'codigo' => '4', 'nombre' => 'ALQUILER DE CANCHA DE FUTBOL DIA', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '8', 'nombre' => 'arroz chaufa amazonico', 'moneda' => 'PEN', 'valorventa' => '28', 'idimpuesto' => 8],

            ); 
            $empresa->productos()->createMany($data);

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '10002',
                'nombre' => 'PRODUCTOS EXTRAS'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array( 
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '5', 'nombre' => 'ALQUILER DE CANCHA DE FUTBOL NOCHE', 'moneda' => 'PEN', 'valorventa' => '50', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '25', 'nombre' => 'CIGARRO LUCKY CAJA', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '34', 'nombre' => 'ENERGIZANTE - ELECTROLIGHT', 'moneda' => 'PEN', 'valorventa' => '3', 'idimpuesto' => 8],

            ); 
            $empresa->productos()->createMany($data);

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '10003',
                'nombre' => 'LICORES'
            );

            $categoria->fill($campos);
            $categoria->save();
 

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '-',
                'nombre' => 'SIN CATEGORÍA'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array( 
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '10', 'nombre' => 'BAYLIS', 'moneda' => 'PEN', 'valorventa' => '20', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '12', 'nombre' => 'CAJA DE CIGARRO', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'ZZ', 'codigo' => '30', 'nombre' => 'DESCRIPCIÓN DE SERVICIOS ', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '31', 'nombre' => 'DESCRIPCIÓN DELPRODUCTO', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '42', 'nombre' => 'JARRA DE VODKA', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '59', 'nombre' => 'VASO DE CACHASA', 'moneda' => 'PEN', 'valorventa' => '12', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '60', 'nombre' => 'VASO DE CHILCANO', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],

            ); 
            $empresa->productos()->createMany($data);

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '20',
                'nombre' => 'BARRA PRINCIPAL'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array( 
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '1', 'nombre' => 'AGUA 1/2', 'moneda' => 'PEN', 'valorventa' => '3', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '2', 'nombre' => 'AGUA 2LT', 'moneda' => 'PEN', 'valorventa' => '8', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '17', 'nombre' => 'CERVEZA NEGRA', 'moneda' => 'PEN', 'valorventa' => '10', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '26', 'nombre' => 'cigarro uni', 'moneda' => 'PEN', 'valorventa' => '2', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '29', 'nombre' => 'cusqueña dorada', 'moneda' => 'PEN', 'valorventa' => '10', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '33', 'nombre' => 'energizante', 'moneda' => 'PEN', 'valorventa' => '3', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '40', 'nombre' => 'INGRESO ', 'moneda' => 'PEN', 'valorventa' => '5', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '51', 'nombre' => 'PILSEN 3 X 25', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '56', 'nombre' => 'promocion 4  budweiser x 20 soles ', 'moneda' => 'PEN', 'valorventa' => '20', 'idimpuesto' => 8],

            ); 
            $empresa->productos()->createMany($data);

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '10',
                'nombre' => 'PROMOCIÓN PILSEN'
            );

            $categoria->fill($campos);
            $categoria->save();


            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '001',
                'nombre' => 'BARRA PRINCIPAL'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array( 
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '14', 'nombre' => 'cecina', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '15', 'nombre' => 'CERVEZA DE TRIGO', 'moneda' => 'PEN', 'valorventa' => '10', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '16', 'nombre' => 'cerveza en lata pilsen', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '18', 'nombre' => 'CERVEZA PILSEN', 'moneda' => 'PEN', 'valorventa' => '9', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '24', 'nombre' => 'CIGARRO LUCKY', 'moneda' => 'PEN', 'valorventa' => '1.5', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '28', 'nombre' => 'CORONA', 'moneda' => 'PEN', 'valorventa' => '10', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '32', 'nombre' => 'electrolay', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '36', 'nombre' => 'GASEOSA DE 1/2', 'moneda' => 'PEN', 'valorventa' => '4', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '37', 'nombre' => 'GASEOSA DE 2 LT', 'moneda' => 'PEN', 'valorventa' => '10', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '38', 'nombre' => 'GASEOSA DE 300 ML', 'moneda' => 'PEN', 'valorventa' => '2', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '55', 'nombre' => 'powered', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '57', 'nombre' => 'REDBULLS', 'moneda' => 'PEN', 'valorventa' => '12', 'idimpuesto' => 8],

            ); 
            $empresa->productos()->createMany($data);

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '002',
                'nombre' => 'COCINA'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array(
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '7', 'nombre' => 'ARROZ CHAUFA  POLLO O CARNE', 'moneda' => 'PEN', 'valorventa' => '20', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '9', 'nombre' => 'ARROZ CHAUFA POLLO/CARNE CALABREZA Y CESINA', 'moneda' => 'PEN', 'valorventa' => '30', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '11', 'nombre' => 'BUFFET', 'moneda' => 'PEN', 'valorventa' => '1224', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '13', 'nombre' => 'CALABREZA', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '19', 'nombre' => 'CESINA', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '20', 'nombre' => 'CHANCHO A LA CAJA CHINA', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '21', 'nombre' => 'CHANCHO A LA PARRILLA', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '22', 'nombre' => 'CHICHARRON DE CHANCHO', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '23', 'nombre' => 'CHULETA DE CHANCHO ', 'moneda' => 'PEN', 'valorventa' => '20', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '35', 'nombre' => 'ensalada mixta', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '39', 'nombre' => 'GUARNICIONES', 'moneda' => 'PEN', 'valorventa' => '5', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '43', 'nombre' => 'JARRRA DE REFRESCO', 'moneda' => 'PEN', 'valorventa' => '8', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '44', 'nombre' => 'LOMO FINO A LO POBRE', 'moneda' => 'PEN', 'valorventa' => '28', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '45', 'nombre' => 'LOMO SALTADO ', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '46', 'nombre' => 'MENU EJECUTIVO', 'moneda' => 'PEN', 'valorventa' => '10', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '47', 'nombre' => 'PESACADO A LA PARRILLA ENTERO', 'moneda' => 'PEN', 'valorventa' => '40', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '48', 'nombre' => 'PESCADO A LA PARRILLA 1/2', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '49', 'nombre' => 'PESCADO A LA PARRILLA 1/4', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '50', 'nombre' => 'PESCADO FRITO ', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '52', 'nombre' => 'PLATO VARIADO', 'moneda' => 'PEN', 'valorventa' => '25', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '53', 'nombre' => 'POLLO CANGA', 'moneda' => 'PEN', 'valorventa' => '22', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '54', 'nombre' => 'PORCCION DE ENSALADA', 'moneda' => 'PEN', 'valorventa' => '8', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'ZZ', 'codigo' => '58', 'nombre' => 'sudado de pescado', 'moneda' => 'PEN', 'valorventa' => '15', 'idimpuesto' => 8],
            ); 
            $empresa->productos()->createMany($data);

            // Table: categoria
            $categoria = new Categoria;
            $campos = array(
                'idempresa' => $empresa->idempresa,
                'codigo' => '003',
                'nombre' => 'INGRESO LOCAL'
            );

            $categoria->fill($campos);
            $categoria->save();

            // Table: producto
            $data = array(
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '6', 'nombre' => 'ALQUILER DE CANCHITA ', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'NIU', 'codigo' => '27', 'nombre' => 'CONSUMO', 'moneda' => 'PEN', 'valorventa' => '0', 'idimpuesto' => 8],
['idcategoria' => $categoria->idcategoria, 'unidadmedida' => 'ZZ', 'codigo' => '41', 'nombre' => 'INGRESO AL LOCAL', 'moneda' => 'PEN', 'valorventa' => '5', 'idimpuesto' => 8],
            ); 
            $empresa->productos()->createMany($data);

            // Table: entidad
            $data = array(
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20555150424', 'entidad' => 'PAVIKRET S.A.C.', 'direccion' => 'AV. PASEO DE LA REPUBLICA NRO. 5181 INT. 1601 ---- SURQUILLO - LIMA LIMA SURQUILLO'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '45875953', 'entidad' => 'SALAS HERRERA WILLIAM DARWIN', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20527143200', 'entidad' => 'GOBIERNO REGIONAL MADRE DE DIOS', 'direccion' => 'JR. CUSCO CDRA NRO. 3 - MADRE DE DIOS TAMBOPATA TAMBOPATA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20601980879', 'entidad' => 'SERVICIOS PERUPETROL BRIKADA SOCIEDAD ÁNÓNIMA CERRADA - SERPEB S.A.C.', 'direccion' => 'AV. ALEGRIA LT. 2 MZ. Q1 - MADRE DE DIOS TAMBOPATA LAS PIEDRAS'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20113604248', 'entidad' => 'CMAC PIURA S.A.C.', 'direccion' => 'JR. AYACUCHO NRO. 353 ---- CENTRO CIVICO - PIURA PIURA PIURA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '10422742889', 'entidad' => 'GUTIERREZ MENDOZA KAREN CRIS', 'direccion' => '- - - -'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '18126726', 'entidad' => 'MORI CASTILLO EDWINK ARNULFO', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '40437560', 'entidad' => 'FERNANDEZ VASQUEZ SERGIO RICARDO', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '000000', 'entidad' => '5to de primaria santa maria', 'direccion' => 'av. madre de dios'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '43725111', 'entidad' => 'PUMA RODRIGUEZ LIZ VANESSA', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '.', 'entidad' => 'amazon planet s.a.c', 'direccion' => '.'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20100077044', 'entidad' => 'HERMES TRANSPORTES BLINDADOS  S A', 'direccion' => 'AV. PRODUCCION NACIONAL NRO. 278 URB. LA VILLA - LIMA LIMA CHORRILLOS'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20114839176', 'entidad' => 'CAJA MUNICIPAL DE AHORRO Y CREDITO CUSCO S.A. - CMAC CUSCO S.A.', 'direccion' => 'AV. LA CULTURA NRO. 1624 URB. CHACHACOMAYOC - CUSCO CUSCO WANCHAQ'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20527240663', 'entidad' => 'ESTANCIA BELLO HORIZONTE S.R.L.', 'direccion' => 'JR. LORETO NRO. 252 URB. CENTRO DE LA CIUDAD - MADRE DE DIOS TAMBOPATA TAMBOPATA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '08', 'entidad' => 'centro educativo secundario alta gracia 5to c ayaviri', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20507920722', 'entidad' => 'PROGRAMA INTEGRAL NACIONAL PARA EL BIENESTAR FAMILIAR - INABIF', 'direccion' => 'AV. SAN MARTIN NRO. 685 - LIMA LIMA PUEBLO LIBRE'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '43408352', 'entidad' => 'ACOSTA RODRIGUEZ CESAR RENATO', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20489951283', 'entidad' => 'SERVICIOS EDUCATIVOS SAN JUAN E.I.R.L.', 'direccion' => 'NRO. B-2 C.H. EMADI - MADRE DE DIOS TAMBOPATA TAMBOPATA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '72221757', 'entidad' => 'HUANCAHUIRE ALLENDE YORDAN JESUS', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20365846961', 'entidad' => 'COLEGIO DE CONTADORES PUBLICOS DE APURIMAC', 'direccion' => 'AV. DAVID S OCAMPO LT. 2 MZ. B - APURIMAC ABANCAY ABANCAY'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '43747248', 'entidad' => 'ministerio publico', 'direccion' => '-jr. ica 843'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20604172358', 'entidad' => 'A & C ARCO S.A.C.', 'direccion' => 'LT. 5 MZ. H22 ASC. CENTRAL UNIFICADA - LIMA LIMA VILLA MARIA DEL TRIUNFO'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20131369124', 'entidad' => 'EJERCITO PERUANO', 'direccion' => 'AV. BOULEVARD NRO. SN - LIMA LIMA SAN BORJA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20131391243', 'entidad' => 'ejercito del peru/oa_cje/pp_ep', 'direccion' => 'avenida del parque s/n'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20513994983', 'entidad' => 'COMPAÑIA MINERA KURI KULLU S.A.', 'direccion' => 'AV. SANTA CRUZ NRO. 830 DPTO. 401 - LIMA LIMA MIRAFLORES'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '43730709', 'entidad' => 'RIOS PINEDA ALEXSEI JHONATAN', 'direccion' => '-jr. ica 843'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '46114018', 'entidad' => '46114018', 'direccion' => 'jr. los amancaes l.141'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '23919461', 'entidad' => 'PERALTA MENACHO LUIS ABELARDO', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20490106210', 'entidad' => 'AMAZON PLANET SOCIEDAD ANONIMA CERRADA', 'direccion' => 'PJ. JAVIER HERAUD NRO. S/N C.P. EL TRIUNFO - MADRE DE DIOS TAMBOPATA LAS PIEDRAS'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '10', 'entidad' => 'checalla checall julio omar', 'direccion' => 'av. sinchi roca'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '46488402', 'entidad' => 'VILLAVERDE NICOLAS ELVIS RAUL', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '1', 'entidad' => 'clientes varios', 'direccion' => 'sin domicilio'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '10454370487', 'entidad' => 'SARMIENTO CABRERA PRISCILLA MERLY', 'direccion' => 'LT. 10 MZ. P P.J. A. B. LEGUIA - TACNA TACNA TACNA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '8', 'entidad' => 'COMUNIDAD TRES ISLAS', 'direccion' => '*'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20600955188', 'entidad' => 'PSP ENERGY S.A.C.', 'direccion' => 'JR. TACNA NRO. 3336 URB. PERU - LIMA LIMA SAN MARTIN DE PORRES'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'A', 'entidad' => 'DELIA JUARES', 'direccion' => '¿'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '1', 'entidad' => 'DIREICAJ-PNP', 'direccion' => 'Av. España 323'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20370114952', 'entidad' => 'XI-DIRECCION TERRITORIAL DE POLICIA-AREQUIPA', 'direccion' => 'AV. ENMEL NRO. 106 - AREQUIPA AREQUIPA YANAHUARA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '#', 'entidad' => 'FAUSTO TACUR', 'direccion' => '*'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '?', 'entidad' => 'FRENTE POLICIAL PUNO', 'direccion' => 'AV EL SOL N°450'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '00000', 'entidad' => 'glorioso 821 6to a', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '/', 'entidad' => 'I.E ALM MIGUELGRAU', 'direccion' => 'CHECACUPE-CANCHIS'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '*', 'entidad' => 'I.E.P SAN JUAN E.I.R.L', 'direccion' => '*'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'I.E.APAFA', 'entidad' => 'I.E.SANTA ROSA-APAFA', 'direccion' => 'JR ZOILA ANTORA S/N'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20309001037', 'entidad' => 'PALMA REAL S.A.C.', 'direccion' => '---- RIO BAJO MADRE DE DIOS KM. 15 - MADRE DE DIOS TAMBOPATA LAS PIEDRAS'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20131312955', 'entidad' => 'SUNAT', 'direccion' => 'AV. GARCILASO DE LA VEGA NRO. 1472 - LIMA LIMA LIMA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'LECHEMAYO', 'entidad' => 'leche mayo andres avelino caseres', 'direccion' => '.'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'X', 'entidad' => 'LISSETT VELASQUEZ', 'direccion' => '@'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'MIGUEL', 'entidad' => 'MIGUEL AGUILAR', 'direccion' => '*'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'T', 'entidad' => 'ministerio publico', 'direccion' => 'x'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '°', 'entidad' => 'MONTACARGAS ZAPLER S.A.C', 'direccion' => 'CAR.PANAMERICANA SUR KM 17,2'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'PAMPAMARCA', 'entidad' => 'MUNUCIPALIDAD DISTRITAL DE PAMPAMARCA', 'direccion' => '.'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '°*', 'entidad' => 'PROMOCION 2018 I.E SAGRADO CORAZON', 'direccion' => '*'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'CLIENTE3', 'entidad' => 'PSP ENERGY S.A.C.', 'direccion' => 'jr. tacna n° 3336'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20103967199', 'entidad' => 'COMERCIAL INDUSTRIAL SELVA S.A.', 'direccion' => 'JR. ARICA NRO. 340 - LORETO MAYNAS IQUITOS'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20218090550', 'entidad' => 'CORPORACION EJECUTORA DE OBRAS S.A.C.', 'direccion' => 'JR. TARAPACA NRO. 255 INT. 101 - LIMA LIMA MIRAFLORES'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '4560196', 'entidad' => 'RODYL ABAB ZAMANTA HUANCA', 'direccion' => '*'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => 'DIRECFIN', 'entidad' => 'U.E *002-DIRECFIN', 'direccion' => 'LOS CIBELES 191-RIMAC'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '01', 'entidad' => 'U.E N.O26DIREICAJ PNP', 'direccion' => 'U.E N.O26DIREICAJ PNP'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20259572887', 'entidad' => 'MONTACARGAS ZAPLER S.A.C.', 'direccion' => 'CAR. PANAMERICANA SUR LT. 5 MZ. D KM. 17.2 Z.I. ZONA PRE-URBANA - LIMA LIMA VILLA EL SALVADOR'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '-', 'entidad' => 'UNA-PUNO', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '20303063766', 'entidad' => 'UNIVERSIDAD ALAS PERUANAS S.A.', 'direccion' => 'AV. SAN FELIPE NRO. 1109 - LIMA LIMA JESUS MARIA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20117925375', 'entidad' => 'COLEGIO DE ENFERMEROS DEL PERU CRXXVI MADRE DE DIOS', 'direccion' => 'JR CAJAMARCA N°681'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20106636011', 'entidad' => 'CENTRO DE CONSERVACION DE ENERGIA Y DEL AMBIENTE', 'direccion' => 'CAL. DERAIN NRO. 198 - LIMA LIMA SAN BORJA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '10437333616', 'entidad' => 'RAMIREZ ZEGARRA RAYNER JESUS', 'direccion' => 'JR. PIURA NRO. C-11 - MADRE DE DIOS TAMBOPATA TAMBOPATA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20100021847', 'entidad' => 'EXPORTADORA EL SOL S.A.C.', 'direccion' => 'JR.AMAZONAZ C.5'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '00000001', 'entidad' => 'vinkinko', 'direccion' => 'sin domicilio'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '42758515', 'entidad' => 'FARFAN LOPEZ AARON', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '45204594', 'entidad' => 'PEREIRA TENTEYO VICTOR HUGO', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 1, 'numerodoc' => '47478529', 'entidad' => 'URQUIA PEIXOT FRANCK BEKER', 'direccion' => '-'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '10424530927', 'entidad' => 'OYARCE ZAPATA DANIEL BENJAMIN', 'direccion' => 'JR. JAIME TRONCOZO LT. 5E MZ. 1D URB. CERCADO - MADRE DE DIOS TAMBOPATA TAMBOPATA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '0', 'entidad' => 'wendy cossio', 'direccion' => 'Q'],
['idempresa' => $empresa->idempresa,'iddocumento' => 5, 'numerodoc' => '7', 'entidad' => 'x1-DIRTPOL-AREQUIPA', 'direccion' => 'AV.EMMEL #106 YANAHURA'],
['idempresa' => $empresa->idempresa,'iddocumento' => 2, 'numerodoc' => '20600695771', 'entidad' => 'NUBEFACT SA', 'direccion' => 'CALLE LIBERTAD 116 10-C MIRAFLORES LIMA'],
            ); 

            $empresa->entidades()->createMany($data);
            

            // Table: sede
            $sede = new Sede;
            $sede->idempresa = $empresa->idempresa; 
            $sede->nombre = 'CASA BARCO'; 
            $sede->direccion = 'TRIUNFO: JR. CESAR VALLEJO Mz 4A L-07';
            $sede->departamento = 'MADRE DE DIOS';
            $sede->provincia = 'TAMBOPATA';
            $sede->distrito = 'LAS PIEDRAS';
            $sede->ubigeo = '170203';
            $sede->codigosunat = '0000';
            $sede->pdffactura = 'TICKET';
            $sede->pdfboleta = 'TICKET';
            $sede->pdfcolor = '25,8,255'; 
            $sede->pdfcabecera = 'CASA VIKINGO';
            $sede->pdfnombre = 'CASA BARCO CLUB'; 
            $sede->save();

            // Table: documentoserie
            $data = array(
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 2,
                    'numero' => 1,
                    'serie' => 'B002',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'B002',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 1,
                    'numero' => 1,
                    'serie' => 'F002',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'F002',
                ], 
            );
            $sede->comprobantes()->createMany($data);

            // Table: sede_users
            $data = array(
                ['idsede' => $sede->idsede]
            );

            $usuario->sedes()->attach($data);


            // Table: sede
            $sede = new Sede;
            $sede->idempresa = $empresa->idempresa; 
            $sede->nombre = 'GRASS SINTETICO'; 
            $sede->direccion = 'Jr Cesar Vallejo 4 A lote 7 Prolongación León Velarde';
            $sede->departamento = 'MADRE DE DIOS';
            $sede->provincia = 'TAMBOPATA';
            $sede->distrito = 'LAS PIEDRAS';
            $sede->ubigeo = '170203';
            $sede->codigosunat = '0000';
            $sede->pdffactura = 'TICKET';
            $sede->pdfboleta = 'TICKET';
            $sede->pdfcolor = '25,8,255';
            $sede->pdfcabecera = 'CASA VIKINGO';
            $sede->pdfnombre = 'CANCHA DE GRASS SINTETICO CASA BARCO CLUB'; 
            $sede->save();

            // Table: documentoserie
            $data = array(
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 2,
                    'numero' => 1,
                    'serie' => 'B003',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'B003',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 1,
                    'numero' => 1,
                    'serie' => 'F003',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'F003',
                ], 
            );
            $sede->comprobantes()->createMany($data);

            // Table: sede_users
            $data = array(
                ['idsede' => $sede->idsede]
            );

            $usuario->sedes()->attach($data);


            // Table: sede
            $sede = new Sede;
            $sede->idempresa = $empresa->idempresa; 
            $sede->nombre = 'CASA VIKINGO 2'; 
            $sede->direccion = 'JR. DANIEL ALCIDES CARRION LT. 10F MZ. D';
            $sede->departamento = 'MADRE DE DIOS';
            $sede->provincia = 'TAMBOPATA';
            $sede->distrito = 'TAMBOPATA';
            $sede->ubigeo = '170101';
            $sede->codigosunat = '0000';
            $sede->pdffactura = 'TICKET';
            $sede->pdfboleta = 'TICKET';
            $sede->pdfcolor = '25,8,255';
            $sede->pdfcabecera = 'CASA VIKINGO';
            $sede->pdfnombre = 'CASA VIKINGO II'; 
            $sede->save();

            // Table: documentoserie
            $data = array(
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 2,
                    'numero' => 1,
                    'serie' => 'B004',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'B004',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 1,
                    'numero' => 1,
                    'serie' => 'F004',
                ],
                [
                    'idempresa' => $empresa->idempresa,
                    'contingencia' => '0',
                    'iddocumentofiscal' => 13,
                    'numero' => 1,
                    'serie' => 'F004',
                ], 
            );
            $sede->comprobantes()->createMany($data);

            // Table: sede_users
            $data = array(
                ['idsede' => $sede->idsede]
            );

            $usuario->sedes()->attach($data);

        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();

        return $this->showMessage('Información cargada');
    }

    public function consultaDniRuc(Request $request) {

        $reglas = [
            'numero' => 'required'
        ];

        $this->validate($request, $reglas); 
        
        $tipo = NULL;
        if (strlen($request->numero) === 8) { // DNI
            $tipo = 1;
        }

        if (strlen($request->numero) === 11) { // RUC
            $tipo = 2;
        }

        if (empty($tipo)) {
            return $this->errorResponse('Número inválido. DNI 8 dígitos, RUC 11 dígitos', 422);
        }

        $data = $this->consultarDNIRUC($tipo, $request->numero);
 
        if (empty($data)) { 
            return $this->errorResponse('Sin datos', 422);
        }
        
        return $this->showAll($data);
    } 

    private function aleatorio($numerodeletras = 10) {

        // $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $caracteres = "abcdefghijklmnopqrstuvwxyz";
        $cadena = ""; 

        for($i=0; $i<$numerodeletras; $i++)
        {
            $cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /*Extraemos 1 caracter de los caracteres 
        entre el rango 0 a Numero de letras que tiene la cadena */
        }

        return $cadena;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Empresa());
        
        $empresa = Empresa::with($resource)->findOrFail($id);
 
        return $this->showOne($empresa);
    }

    public function cuenta()
    {
        $userAuth = auth()->user();

        $this->fooShow($resource, new Empresa());
        
        $empresa = Empresa::with($resource)->findOrFail($userAuth->idempresa);
 
        return $this->showOne($empresa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {   
        $reglas = [
            'ruc' => 'required',
            'razonsocial' => 'required'  
        ];  
 
        $this->validate($request, $reglas); 

        $campos = $request->all();

        $empresa->fill($campos);    
 
        // if (!$empresa->isDirty())
        //      return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);

        DB::beginTransaction(); 
        try { 
             
            $empresa->save(); 

            if ($request->has('medidas')) {
                // Table: unidadempresa
                $empresa->medidas()->sync($request->medidas);
            } 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($empresa); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {

        // $empresa = Empresa::select('idempresa', 'nombre')
        //                 ->findOrFail($id);
        
        // return $this->showOne($empresa);

        $mensajes = array();

        DB::beginTransaction(); 
        try {  

            // \DB::enableQueryLog(); 
            
            $usuarios = $empresa->usuarios;  // Retorna lo mismo
            // $usuarios = User::select('id')->where('idempresa', $id) ->get(); // Retorna lo mismo

            // $empresa->usuarios() : Devuelve Relacions HasMany
            // $empresa->usuarios : Devuelve Collection de modelo User

            foreach ($usuarios as $user)
            {
                $countModulos = $user->modulos()->detach();         // modulo_users
                $countSedes = $user->sedes()->detach();             // sede_users        
                $mensajes[] = array('tabla' => 'modulo_users', 'cantidad' => $countModulos);
                $mensajes[] = array('tabla' => 'sede_users', 'cantidad' => $countSedes);
                Log::info('modulo_users:'. $countModulos); 
                Log::info('sede_users:'. $countSedes); 
            }

            $ventas = Venta::select('idventa')->where('idempresa', $empresa->idempresa) ->get();
            foreach ($ventas as $venta)
            {
                $countVentadet = $venta->ventadet()->delete();      // ventadet
                $countVentapago = $masivo->ventapago()->delete();   // ventapago
                $mensajes[] = array('tabla' => 'ventadet', 'cantidad' => $countVentadet);
                $mensajes[] = array('tabla' => 'ventapago', 'cantidad' => $countVentapago);
                Log::info('ventadet:'. $countVentadet); 
                Log::info('ventapago:'. $countVentapago); 
            }

            $masivos = Masivo::select('id')->where('idempresa', $empresa->idempresa) ->get();
            foreach ($masivos as $masivo)
            {
                $count = $masivo->masivodet()->delete();      // masivodet        
                $mensajes[] = array('tabla' => 'masivodet', 'cantidad' => $count);
                Log::info('masivodet:'. $count);
            }

            $count = $empresa->medidas()->detach();           // unidadempresa  
            $mensajes[] = array('tabla' => 'unidadempresa', 'cantidad' => $count);
            Log::info('unidadempresa:'. $count);
            $count = $empresa->modulos()->detach();           // moduloempresa
            $mensajes[] = array('tabla' => 'moduloempresa', 'cantidad' => $count);
            Log::info('moduloempresa:'. $count);
            $count = $empresa->categorias()->delete();        // categoria
            $mensajes[] = array('tabla' => 'categoria', 'cantidad' => $count);
            Log::info('categoria:'. $count);
            $count = $empresa->comprobantes()->delete();      // documentoserie
            $mensajes[] = array('tabla' => 'documentoserie', 'cantidad' => $count);
            Log::info('documentoserie:'. $count);
            $count = $empresa->sedes()->delete();             // sede
            $mensajes[] = array('tabla' => 'sede', 'cantidad' => $count);
            Log::info('sede:'. $count);
            $count = $empresa->usuarios()->delete();          // users
            $mensajes[] = array('tabla' => 'users', 'cantidad' => $count);
            Log::info('users:'. $count);
            $count = $empresa->entidades()->delete();         // entidad 
            $mensajes[] = array('tabla' => 'entidad', 'cantidad' => $count);   
            Log::info('entidad:'. $count);
            $count = $empresa->productos()->delete();         // producto
            $mensajes[] = array('tabla' => 'producto', 'cantidad' => $count);
            Log::info('producto:'. $count);
            $count = $empresa->ventas()->delete();            // venta
            $mensajes[] = array('tabla' => 'venta', 'cantidad' => $count);
            Log::info('venta:'. $count);
            $count = $empresa->masivos()->delete();           // masivo
            $mensajes[] = array('tabla' => 'masivo', 'cantidad' => $count);
            Log::info('masivo:'. $count);
            $count = $empresa->delete();                      // empresa
            $mensajes[] = array('tabla' => 'empresa', 'cantidad' => $count);
            Log::info('empresa:'. $count);

            // dd(\DB::getQueryLog()); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showMessage($mensajes);
    }

    public function updateimagen(Request $request)
    {    
        // $idempresa = Config::get('constants.empresas.osi');  
        // $idAuth = Config::get('constants.usuarios.julio');  

        $reglas = [ 
            'imagen' => 'required|file',
            'tipo' => 'required'
        ];  

        $this->validate($request, $reglas);  

        $userAuth = auth()->user();

        $empresa = Empresa::findOrFail($userAuth->idempresa);
       
        DB::beginTransaction(); 
        try {  

            if ($request->tipo === 'logocuadrado') {
                if ($empresa->logocuadrado) {
                    Storage::disk('empresa')->delete($empresa->idempresa . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $empresa->logocuadrado);
                }

                $pathImage = $request->imagen->store($empresa->idempresa . '/img', 'empresa');
                $empresa->logocuadrado = explode("/", $pathImage)[2];
                $empresa->save(); 
            }

            if ($request->tipo === 'logopdf') {
                if ($empresa->logopdf) {
                    Storage::disk('empresa')->delete($empresa->idempresa . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $empresa->logopdf);
                }

                $pathImage = $request->imagen->store($empresa->idempresa . '/img', 'empresa');
                $empresa->logopdf = explode("/", $pathImage)[2];
                $empresa->save(); 
            }            

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($empresa);
    } 

    private function consultarDNIRUC($tipo, $numero) { 
        
        $retorno = NULL;

        // 1. Formatear URL 
        if ($tipo === 1) { // DNI
            $url = "https://dniruc.apisperu.com/api/v1/dni/". $numero .
                   "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNoYXVjYWNoYXZlekBnbWFpbC5jb20ifQ.O45pJ4s0wUtVRsB2LsGqQAIlsPky2KUWAvj7D_DQllo";


            \Log::info(print_r($url, true));

            // 2. Enviar PSE  
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);
            curl_close($ch);

            // 3. Leer respuesta
            $leer_respuesta = json_decode($respuesta, true); 

            if (isset($leer_respuesta['dni'])) { 
                $retorno = array(
                    'dni' => $leer_respuesta['dni'],
                    'nombres' => $leer_respuesta['nombres'],
                    'apellidoPaterno' => $leer_respuesta['apellidoPaterno'],
                    'apellidoMaterno' => $leer_respuesta['apellidoMaterno']
                );
            } 

            return $retorno;
        }

        if ($tipo === 2) { // RUC
            $endpoint = "https://api.migoperu.pe/api/v1/ruc";
            $token = "fc4ee885-9c7b-4862-8384-9dc5ab6401bf-97719825-5fce-4e44-be20-ef431912be14";
            $ruc = $numero;
            $data = array(
                "token" => $token,
                "ruc"   => $ruc
            );

            $ch = curl_init($endpoint);
            curl_setopt($ch, 
                CURLOPT_HTTPHEADER, 
                array(
                    'Content-Type: application/json', 
                    'Accept: application/json'
                ));
            curl_setopt($ch, CURLOPT_POST, 1);            
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $json = curl_exec($ch);
            curl_close($ch);

            $leer_respuesta = json_decode($json, true); 
            
            if (isset($leer_respuesta['success']) && $leer_respuesta['success']) {  
                $retorno = array(
                    'ruc' => $leer_respuesta['ruc'],
                    'razonSocial' => $leer_respuesta['nombre_o_razon_social'],
                    'direccion' => $leer_respuesta['direccion'],
                    'departamento' => $leer_respuesta['departamento'],
                    'provincia' => $leer_respuesta['provincia'],
                    'distrito' => $leer_respuesta['distrito'],
                    'ubigeo' => $leer_respuesta['ubigeo']                    
                );
            }
            // Usando librería GuzzleHttp: https://docs.migoperu.pe/endpoints/ruc
            return $retorno;
        }
    }
}
