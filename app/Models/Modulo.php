<?php

namespace App\Models;

use App\Models\Entidad;
use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulo';
    protected $primaryKey = 'idmodulo';
    public $timestamps = false;
    
    protected $fillable = [
        'parent',
    	'nombre',
        'url', 
        'orden',
    	'nivel',    	
        'maticon'
    ];

    public $filterWhere = [
        'idmodulo',
        'nombre'
    ];

    protected $hidden = [
        'pivot'
    ];

    protected static function boot()
    {
        parent::boot();
     
        static::addGlobalScope('ordenar', function ($query) {
            return $query->orderBy('orden', 'asc');    
        });
    }

    //Recursos a solicitar
    public static function recursos() 
    {
        return array('parent', 'empresas', 'perfiles', 'usuarios');
    } 

    //Relaciones
    public function parent()
    {
        return $this->belongsTo(Modulo::class, 'parent_id');
    }
    
    public function empresas() 
    {
    	return $this->belongsToMany(Empresa::class);
    }

    public function perfiles() 
    {
        return $this->belongsToMany(Perfil::class);
    } 

    public function usuarios() 
    {
        return $this->belongsToMany(Entidad::class);
    } 

}
