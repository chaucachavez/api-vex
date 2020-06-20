<?php

namespace App\Models;

use App\Models\Venta;
use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Unidad;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes; 

    protected $table = 'users'; 

    protected $fillable = [
    	'name',
        'email',
        // ''password      
        // 'email_verified_at',
        // 'verified',
        // 'verification_token'
        'celular',
        'acceso',
        'administrador',
        'imgperfil',
        'idempresa',
    ];

    protected $hidden = [ 
        'password',
        'verification_token',
        'email_verified_at'
    ];
 
    public $filterWhere = [
    	'id', 
        'name',
        'idempresa'
    ]; 

    //Recursos a solicitar
    public static function recursos() {
        return array('empresa', 'sedes',  'modulos');
    }

    //Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa');
    }  

    public function sedes() 
    {
        return $this->belongsToMany(Sede::class, 'sede_users', 'iduser', 'idsede');
    }

    public function modulos() 
    {
        return $this->belongsToMany(Modulo::class, 'modulo_users', 'iduser', 'idmodulo')->withPivot('permiso');
    } 

    public function ventas() {
        return $this->hasMany(Unidad::class, 'id_created_at');
    }



    // JWT
    // https://medium.com/@experttyce/c%C3%B3mo-crear-un-api-rest-con-laravel-5-7-y-jwt-token-94b79c533c6d

    // Tuve problemas con Method Illuminate\Auth\SessionGuard::factory does not exist, entonces
    // ejecute comando de stackoverflow y se soluciono 
    //https://stackoverflow.com/questions/49236295/method-illuminate-auth-sessionguardusers-does-not-exist
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
