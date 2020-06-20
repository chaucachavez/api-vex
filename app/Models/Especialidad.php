<?php

namespace App\Models;
 
use App\Models\Entidad;
use App\Models\Citamedica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{	
	// use SoftDeletes;

	protected $table = 'especialidad';
    protected $primaryKey = 'idespecialidad';
	// protected $dates = ['deleted_at'];

    protected $fillable = [  
        'nombre', 
        'descripcion' 
    ];

    public $filterWhere = [
        'idespecialidad',
        'idempresa',
        'nombre', 
        'descripcion' 
    ];

    protected $hidden = [
        'pivot'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('citasmedicas', 'usuarios');        
    }

    //Relaciones
    public function citasmedicas()
    {
        return $this->belongsToMany(Citamedica::class);
    } 

    public function usuarios() 
    {
        return $this->belongsToMany(Entidad::class);
    }
 
}
