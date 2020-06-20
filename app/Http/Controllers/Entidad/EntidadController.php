<?php

namespace App\Http\Controllers\Entidad;

use App\Models\Ip;
use App\Models\User;
use App\Models\Tarifa;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Horario;
use App\Models\Historia;
use App\Models\Logacceso;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class EntidadController extends ApiController
{   

    public function __construct() 
    { 
        //$this->middleware('client.credentials')->only(['resend' ]);
        //$this->middleware('auth:api')->except(['store', 'verify', 'resend']);
        $this->middleware('transform.input:' . Entidad::class)->only(['store', 'update']); 
        $this->middleware('jwt', ['except' => ['authenticate', 'forgotPassword']]); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    

        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Entidad());
              
        $betweenDate = []; 
        if (request()->filled(['nacimientoFrom', 'nacimientoTo'])) {
            $betweenDate = array(request()->input('nacimientoFrom'), request()->input('nacimientoTo')); 
        } 

        $likeEntidad = request()->filled(['likeEntidad']) ? request()->input('likeEntidad') : NULL;
        $likeNumerodoc = request()->filled(['likeNumerodoc']) ? request()->input('likeNumerodoc') : NULL; 
        
        $fields = request()->filled(['fields']) ? explode(',', request()->input('fields'))  : NULL; 
        
        // DB::enableQueryLog();
        $query = Entidad::with($resource)
                ->where($where)
                ->orderBy($orderName, $orderSort)
                ->where('idempresa', auth()->user()->idempresa);

            if ($fields)
                    $query->select($fields);

            if ($likeEntidad) 
                $query->where('entidad', 'LIKE', '%'. $likeEntidad .'%');

            if ($likeNumerodoc) 
                $query->where('numerodoc', 'LIKE', '%'. $likeNumerodoc .'%');

            if ($betweenDate)
                $query->whereBetween('nacimiento', $betweenDate);

            if ($pageSize)
                $data = $query->paginate($pageSize);
            else
                $data = $query->get();
            
            // dd(DB::getQueryLog());
            // dd($data);
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
        $iddocumento = $request->iddocumento;
        $numerodoc = $request->numerodoc;

        // Validaciones con Request
        $reglas = [          
            'entidad' => 'required',   
            'apellidopat' => 'required_if:iddocumento,==,1,3,4,6,7',
            'nombre' => 'required_if:iddocumento,==,1,3,4,6,7', 
        ];

        $this->validate($request, $reglas);

        if ($iddocumento === 1 && strlen($numerodoc) !== 8) {
            return $this->errorResponse("DNI debe tener 8 dígitos", 422);
        }

        if ($iddocumento === 2 && strlen($numerodoc) !== 11) {
            return $this->errorResponse("RUC debe tener 11 dígitos", 422);
        }

        if ($iddocumento === 2 && !in_array(substr($numerodoc, 0, 2), [10, 20])) {
            return $this->errorResponse("RUC debe empezar con [10] p [20]", 422);
        }

        // Validaciones con BD
        if ($request->filled('iddocumento') && $request->filled('numerodoc')) { 

            // Log::info();

            $exists = Entidad::where([
                    'idempresa' => auth()->user()->idempresa, 
                    'iddocumento' => $iddocumento,
                    'numerodoc' => $numerodoc
                ])->exists();

            if ($exists)
                return $this->errorResponse("Número de documento existe", 422);
        }

        if ($request->filled('entidad')) { 
            $exists = Entidad::where([
                    'idempresa' => auth()->user()->idempresa, 
                    'entidad' => $request->entidad 
                ])->exists();

            if ($exists)
                return $this->errorResponse("Persona ya existe", 422);
        } 

        $campos = $request->all();

        $entidad = new Entidad();

        $entidad->fill($campos);
        $entidad->idempresa = auth()->user()->idempresa;

        DB::beginTransaction(); 
        try {
            $entidad->save(); 

            if ($request->filled('sedes')) {
                $entidad->sedes()->attach($request->sedes);
            }

            if ($request->filled('especialidades')) {
                $entidad->especialidades()->attach($request->sedes);
            }

            if ($request->filled('historias')) {
                $campos = array();
                foreach($request->historias as $i => $row) {
                    $campos[] = array(
                        'idpaciente' => $entidad->identidad,
                        'idsede' => $row['idsede'],
                        'hc' => $row['hc'] 
                    ); 
                }
                $entidad->historias()->insert($campos);  
            } 

            if ($request->filled('tarifas')) {
                $campos = array();
                foreach($request->tarifas as $i => $row) {
                    $campos[] = array(
                        'idmedico' => $entidad->identidad,
                        'idsede' => $row['idsede'],
                        'idproducto' => '1',
                        'preciounit' => $row['preciounit']
                    ); 
                } 
                $entidad->tarifas()->insert($campos); 
            } 
        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($entidad); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Entidad());
        
        $entidad = Entidad::with($resource)->findOrFail($id);
        
        // if ($entidad->idempresa !== auth()->user()->idempresa ) {
        //     return $this->errorResponse('Restringido el acceso por permisos.', 422);
        // }

        return $this->showOne($entidad);      
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entidad $entidade)
    {          
        // return $this->showOne($entidad); 

        $reglas = [           
            'apellidopat' => 'required_if:iddocumento,==,1,3,4',
            'entidad' => 'required_if:iddocumento,==,2'
        ];      

        $this->validate($request, $reglas); 

        $campos = $request->all();
        $entidade->fill($campos);

        if (!$entidade->isDirty() && !$request->has('sedes'))
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422); 

        DB::beginTransaction(); 
        try {
            if ($request->has('sedes')) {
                //sync(Elimina y Ingresa), attach(Ingresa repite), syncWithoutDetaching(Ingresa)
                $entidade->sedes()->sync($request->sedes);
            }

            if ($request->has('especialidades')) {
                $entidade->especialidades()->sync($request->especialidades);
            }

            if ($request->has('historias')) {
                foreach ($request->historias as $row) {
                    $historia = Historia::firstOrNew(
                        array('idpaciente' => $entidade->identidad, 'idsede' => $row['idsede'])
                    ); 

                    $historia->fill($row); 
                    $historia->idpaciente = $entidade->identidad; 

                    $historia->save();
                }
            }

            if ($request->has('tarifas')) {
                foreach ($request->tarifas as $row) {  
                    $tarifa = Tarifa::firstOrNew(
                        array('idmedico' => $entidade->identidad, 'idsede' => $row['idsede'], 'idproducto' => $row['idproducto']), 
                        array('preciounit' => $row['preciounit'])
                    );
                    $tarifa->preciounit = $row['preciounit'];
                    $tarifa->save();
                } 

                // Comprender el beginTransaction 
                // Validacion asicrona cuando no tiene tipodocumento
                // return $this->errorResponse($tarifa, 422);
            }

            $entidade->save(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($entidade); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entidad $entidade)
    {     
        if ($entidade->ventas()->exists()) 
        {
            return $this->errorResponse('Cliente tiene ventas relacionadas.' , 422); 
        } 

        $entidade->id_deleted_at = auth()->user()->id;

        DB::beginTransaction(); 
        try {   
            
            $entidade->save(); 
            $entidade->delete(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($entidade);
    } 

    public function empresaToken(Request $request) {

        
        
        //Validaciones con Request
        $reglas = [
            'idempresa' => 'required'
        ];

        $this->validate($request, $reglas); 
 
        $userAuth = auth()->user();

        $user = User::findOrFail($userAuth->id);
        $user->idempresa = $request->idempresa;
        $user->save(); 

        //Elminar token
        auth()->logout();

        // Crear token
        $token = auth()->tokenById($user->id);

        // Grabar log de acceso
        $Logacceso = new Logacceso();

        $fill = array(
            'identidad' => $user->id,
            'fechain' =>  date('Y-m-d'),
            'horain' =>  date('H:i:s'),                                    
            'token' => 'Bearer ' . $token,
            'tokenstatus' => '1'
        );

        $Logacceso->fill($fill);
        $Logacceso->save();

        return $this->showMessage(['token' => $token]);
    }

    public function authenticate(Request $request) 
    { 
        //Validaciones con Request
        $reglas = [ 
            'email' => 'required',
            'password' => 'required'             
        ];

        $this->validate($request, $reglas); 
 
        $where = array( 
            'email' => $request->email 
        ); 
  
        // $User = User::select('id', 'name', 'email', 'idempresa', 'imgperfil')->with(
        //     'empresas:empresa.idempresa,ruc,razonsocial,nombre', 
        //     'sedes:sede.idsede,nombre', 
        //     'perfiles:perfil.idperfil,perfil.nombre',
        //     'perfiles.modulos:modulo.idmodulo,modulo.nombre,modulo.nivel,modulo.url,modulo.maticon,modulo.parent'
        // )->where($where)->first();

        $User = User::select('id', 'name', 'email', 'idempresa', 'imgperfil', 'acceso')
                ->with(
                    // 'empresa:idempresa', 
                    'sedes:sede.idempresa,sede.idsede,sede.nombre', 
                    'modulos:modulo.idmodulo,modulo.nombre,modulo.nivel,modulo.url,modulo.maticon,modulo.parent'
                )->where($where)->first();

        if (!$User) {
            return $this->errorResponse("Usuario no existe", 422); 
        }  

        if ($User->acceso === '0') { 
            return $this->errorResponse('Usuario sin acceso al sistema. Contactarse con administración para habilitar el acceso.', 401); 
        } 
 
        $credentials = request(['email', 'password']);

        $token = auth()->claims(['idempresa' => 1])->attempt($credentials);

        if (!$token) { 
            return $this->errorResponse('Contraseña incorrecta', 401); 
        }

        // Grabar log de acceso
        $Logacceso = new Logacceso();

        $fill = array(
            'identidad' => $User->id,
            'fechain' =>  date('Y-m-d'),
            'horain' =>  date('H:i:s'),                                    
            'token' => 'Bearer ' . $token,
            'tokenstatus' => '1'
        );

        $Logacceso->fill($fill);
        $Logacceso->save();

        // Configuracion general
        $empresa = Empresa::select('preciounitario', 'mediopago', 'logopdf', 'logocuadrado', 'idempresa', 'nombre')->findOrFail($User->idempresa);

        $settings = array(
            'preciounitario' => $empresa->preciounitario === '1' ? true : false,
            'mediopago' => $empresa->mediopago === '1' ? true : false,
            'logopdf' => $empresa->logopdf,
            'logocuadrado' => $empresa->logocuadrado,
            'idempresa' =>  $empresa->idempresa,
            'nombre' =>  $empresa->nombre
        );

        return $this->showMessage(['token' => $token, 'user' => $User, 'settings' => $settings]);
    }

    public function logout(Request $request) {

        //Validaciones con Header
        if (empty($request->header('Authorization'))) {
            return $this->errorResponse('Token es requerido', 422);
        }

        $where = array(
            'logacceso.token' => $request->header('Authorization')
        );

        $Logacceso = Logacceso::where($where)->first();

        if (!$Logacceso) {
            return $this->errorResponse("JWT: Token no existe", 400); 
        }

        $fill = array( 
            'fechaout' =>  date('Y-m-d'),
            'horaout' =>  date('H:i:s')                         
        ); 

        $Logacceso->fill($fill);
        $Logacceso->save();

        auth()->logout();

        return $this->showMessage('Close');
    }

    public function verify($token) {  
        // Validaciones con BD
        $userAuth = auth()->user(); 

        if ($userAuth->verified === '1') { 
            return $this->errorResponse("Cuenta ya se encuentra verificada. Ya puedes ingresar a tu cuenta.", 422);
        }

        $user = User::where('verification_token', $token)->firstOrFail();
 
        $user->verified = '1';
        $user->verification_token = null;
        $user->save();
 
        return $this->showOne($user);
    }   

    public function forgotPassword(Request $request) {

        $reglas = [
            'email' => 'required'            
        ];

        $this->validate($request, $reglas);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario) {
            return $this->errorResponse('No existe el correo "'. $request->email.'" especificado', 422);
        }

        // Crear token
        $token = auth()->tokenById($usuario->id);
        // $usuario->forgot_token = $token;
 
        \Log::info(print_r(date('H:i:s') . ' inicio.', true)); 
        Mail::to($usuario->email)->send(new ForgotPassword($usuario, $token)); 
        \Log::info(print_r(date('H:i:s') . ' fin ' . $request->email, true));
 
        
        return $this->showMessage('Se ha enviado correo a '. $usuario->email .' para restablececer contraseña'); 
    } 

    

    public function me($token) {  

        // auth()->logout();
        $userAuth = auth()->user(); //De no exitir provoca excepción en Handler.php
        // $usuario = User::select('id', 'name', 'email', 'idempresa', 'celular', 'imgperfil')->findOrFail($userAuth->id); 
         
        return $this->showOne($userAuth); 
    }

    public function meUpdate(Request $request, $token) {  

        $userAuth = auth()->user();
        $usuario = User::findOrFail($userAuth->id);

        $reglas = [
            'name' => 'required',
            'email' => 'required'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all();

        $usuario->fill($campos);  

        if ($request->filled('password')) { 
            $usuario->password = bcrypt($request->password);
        } 

        $usuario->save(); 
        
        return $this->showOne($usuario); 
    }

    public function resetPassword(Request $request, $token) 
    {
        $reglas = [
            'password' => 'required'            
        ];

        $this->validate($request, $reglas);

        $userAuth = auth()->user();

        $usuario = User::findOrFail($userAuth->id);

        $usuario->password = bcrypt($request->password);
        $usuario->save();

        auth()->logout();

        return $this->showMessage('La contraseña a sido cambiado');
    }

    public function updateimagen(Request $request, Entidad $entidade)
    {      

        $reglas = [ 
            'imagen' => 'required|file'
        ];  
 
        $this->validate($request, $reglas);        
 
        DB::beginTransaction(); 
        try {  

            if ($entidade->imgperfil) {
                Storage::delete($entidade->imgperfil);
            }

            $entidade->imgperfil = $request->imagen->store($entidade->identidad);  
            $entidade->save();  

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($entidade); 
    }

     
}
