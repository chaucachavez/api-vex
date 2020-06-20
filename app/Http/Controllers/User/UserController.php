<?php

namespace App\Http\Controllers\User;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class UserController extends ApiController
{   
    public function __construct() 
    { 
        $this->middleware('jwt', ['except' => ['authenticate', 'forgotPassword']]); 
    }
   
    public function index()
    {     
        // dd('Hola');
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new User());
         
        $likeNombre = request()->filled(['likeNombre']) ? request()->input('likeNombre') : NULL;  
        // dd($resource);
        // DB::enableQueryLog();
        $query = User::with($resource)
                ->where($where) 
                ->orderBy($orderName, $orderSort);            

        if ($likeNombre) 
            $query->where('name', 'LIKE', '%'. $likeNombre .'%');  

        if ($pageSize)
            $data = $query->paginate($pageSize);
        else
            $data = $query->get();
        
        // dd(DB::getQueryLog());
        return $this->showPaginateAll($data);
    } 
     
   
    public function store(Request $request)
    {
        // Validaciones con Request
        $reglas = [
            'name' => 'required', 
            'email' => 'required',
            'password' => 'required',       
            'acceso' => 'required'
        ];

        $this->validate($request, $reglas);

        // Validaciones con BD        
        $exists = User::where([
                'email' => $request->email 
            ])->exists();

        if ($exists)
            return $this->errorResponse("Correo ya se encuentra registrado.", 422);
 
        $user = new User();

        $user->fill($request->all());  

        $user->password = bcrypt($request->password); 
        $user->idempresa = auth()->user()->idempresa;
        $user->id_created_at = auth()->user()->id;

        DB::beginTransaction(); 
        try { 

            $user->save(); 

            if ($request->has('sedes')) {
                // Table: sede_users
                $user->sedes()->attach($request->sedes);
            } 

            if ($request->has('modulos')) {
                // Table: modulo_users
                $data = array();
                foreach ($request->modulos as $value) {
                    $data[] = array(
                        'idmodulo' => $value['idmodulo'], 
                        'permiso' => $value['permiso']
                    );
                }

                $user->modulos()->attach($data);
            }
            
        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($user); 
    }
    
    public function show($id)
    {
        $this->fooShow($resource, new User());

        // DB::enableQueryLog();

        $user = User::with($resource)->findOrFail($id);
        
        if (array_search('modulos', $resource) >= 0) { 
            foreach($user->modulos as $row) {
                $row->modulo_users = array('permiso' => $row->pivot->permiso); 
            }
        }

        // dd(DB::getQueryLog());

        return $this->showOne($user); 
    }

    public function update(Request $request, User $user)
    {
        // Validaciones con Request
        $reglas = [
            'name' => 'required', 
            'email' => 'required',
            // 'password' => 'required',
            'acceso' => 'required'
        ];

        $this->validate($request, $reglas);

        // Validaciones con BD
        if ($request->filled('email')) { 
            $exists = User::where([
                    'email' => $request->email,
                ])
            ->whereNotIn('id', [$user->id])
            ->exists();

            if ($exists)
                return $this->errorResponse("Correo ya se encuentra registrado.", 422);
        }

        $campos = $request->all();

        /*Cambiar contraseña*/
        if ($request->filled('password')) { 
            $user->password = bcrypt($request->password);
        } else {
            unset($campos['password']);
        }

        $user->fill($campos);  

        // if (!$user->isDirty())
        //      return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422); 

        DB::beginTransaction(); 
        try { 

            $user->save(); 

            if ($request->has('sedes')) {
                // Table: sede_users
                $user->sedes()->sync($request->sedes);
            } 

            if ($request->has('modulos')) {

                // Table: modulo_users
                $data = array();
                foreach ($request->modulos as $value) {
                    $data[] = array(
                        'idmodulo' => $value['idmodulo'], 
                        'permiso' => $value['permiso']
                    );
                }

                $user->modulos()->sync($data);
            }
            
        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($user); 
    }

    public function destroy(User $user)
    {
        if ($user->administrador === '1')
            return $this->errorResponse("Cuenta ADMINISTRADOR no se puede eliminar.", 422);

        $user->id_deleted_at = auth()->user()->id; 
        $user->save();

        if ($user->ventas()->exists()) 
        {
            return $this->errorResponse('Usuario tiene ventas creadas.' , 422); 
        }

        DB::beginTransaction(); 
        try { 

            $user->delete();
            $user->sedes()->sync([]);
            $user->modulos()->sync([]);

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($user);
    }

    public function updateImagenPerfil(Request $request)
    {     
        $reglas = [ 
            'imagen' => 'required|file'
        ];  
 
        $this->validate($request, $reglas);  

        $userAuth = auth()->user();

        $user = User::findOrFail($userAuth->id);

        DB::beginTransaction(); 
        try {  

            if ($user->imgperfil) {
                Storage::disk('persona')->delete($user->id . DIRECTORY_SEPARATOR . $user->imgperfil);
            }

            $pathImage = $request->imagen->store($user->id, 'persona');
            $user->imgperfil = explode("/", $pathImage)[1];
            $user->save(); 

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($user);
    }
}
