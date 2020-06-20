<?php

namespace App\Models;

use App\Models\Entidad;
use App\Models\Modulo; 
use App\Models\Superperfil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    // use SoftDeletes;

    protected $table = 'perfil';
    protected $primaryKey = 'idperfil';
    // protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $fillable = [    
        'idsuperperfil',   
        'nombre', 
        'descripcion',   
        'activo'
    ];

    public $filterWhere = [
    	'idperfil',
        'idsuperperfil',
        'idempresa',
        'nombre',
        'descripcion',
        'nuevo',
        'editar',
        'eliminar',
        'activo'
    ];

    protected $hidden = [
        'pivot',
        'deleted_id',
        'deleted_at'
    ]; 

    //Recursos a solicitar
    public static function recursos() {
        return array('superperfil', 'usuarios', 'modulos');
    }

    //Relaciones
    public function superperfil()
    {   
        // return $this->belongsTo('App\Post', 'foreign_key', 'other_key');
        return $this->belongsTo(Superperfil::class, 'idsuperperfil');
    }

    // public function usuarios() 
    // {
    // 	return $this->belongsToMany(Entidad::class);
    // }  
    public function usuarios()
    {   
        //return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
        return $this->hasMany(Entidad::class, 'idperfil');
    } 

    public function modulos() 
    {
        return $this->belongsToMany(Modulo::class, 'perfilmodulo', 'idperfil', 'idmodulo');
    }  

}
