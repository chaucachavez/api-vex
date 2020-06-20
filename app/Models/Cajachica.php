<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Apertura;
use App\Models\Docnegocio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cajachica extends Model
{
    use SoftDeletes;

    protected $table = 'cajachica';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'sede_id',
		'apertura_id',
		'personal_id',
		'docnegocio_id',
		'tipo',
		'fecha',
		'total',
		'numero',
		'proveedor_id',
		'descripcion',
		'created_id',
		'updated_id',		
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'personal', 'docnegocio', 'proveedor', 'apertura');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function personal()
    {
        return $this->belongsTo(Entidad::class, 'personal_id');
    }

    public function docnegocio()
    {
        return $this->belongsTo(Docnegocio::class);
    }  

    public function proveedor()
    {
        return $this->belongsTo(Entidad::class, 'proveedor_id');
    }  

    public function apertura()
    {
        return $this->belongsTo(Apertura::class);
    }  

}
