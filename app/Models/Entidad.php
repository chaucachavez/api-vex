<?php

namespace App\Models;
  
use App\Models\Sede;
use App\Models\Venta;
use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Tarifa;
use App\Models\Cargoorg;
use App\Models\Documento;
use App\Scopes\UserScope;
use App\Models\Especialidad;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Entidad extends Model 
{   
    use Notifiable, HasApiTokens, SoftDeletes; 
    
    protected $table = 'entidad';
    protected $primaryKey = 'identidad';

    protected $fillable = [    
        'idempresa', 
        'iddocumento', 
        'numerodoc',   
        'apellidopat', 
        'apellidomat', 
        'nombre', 
        'entidad',
        'direccion',   
        'email',
        'telefono',
        'afiliado',
        'personal',
        'cliente',
        'proveedor'
    ]; 

    protected $hidden = [
        'pivot',  
        'deleted_at' 
    ];

    public $filterWhere = [
        'identidad',
        'idempresa', 
        'iddocumento', 
        'numerodoc',   
        'apellidopat', 
        'apellidomat', 
        'nombre', 
        'entidad',
        'direccion',   
        'email',
        'telefono',
        'afiliado',
        'personal',
        'cliente',
        'proveedor'
    ];
    
    
    //Scope, construye e inicaliza el modelo
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserScope);
    }

    //
    public function setNombreAttribute($valor) 
    {
        // $this->attributes['nombre'] = mb_strtolower($valor,'UTF-8');
        $this->attributes['nombre'] = $valor;
    }

    public function getNombreAttribute($valor) 
    {
        return ucfirst($valor);
    } 

    // Responsabilidad se delega al FrontEnd
    // public function setEntidadAttribute($valor) 
    // {        
    //     $this->attributes['entidad'] = mb_strtoupper($valor,'UTF-8'); 
    // }

    public function setEmailAttribute($valor) 
    {        
        $this->attributes['email'] = strtolower($valor);

    }

    //static: no requerimos de una instancia de Usuario para generar el token
    public static function generarVerificationToken() 
    {
        return str_random(40);
    }

    //Recursos a solicitar
    public static function recursos() {
        return array('documento', 'sedes', 'ventas');
    }

    public static function whereRango() {
        return array('nacimientoFrom', 'nacimientoTo');
    }

    //Relaciones
 
    public function documento()
    {
        return $this->belongsTo(Documento::class, 'iddocumento');
    }

    public function sedes() 
    {
        return $this->belongsToMany(Sede::class, 'entidadsede', 'identidad', 'idsede');
    } 

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idcliente');
    } 
}

