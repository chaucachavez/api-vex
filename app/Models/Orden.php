<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Mediopago;
use App\Models\Docnegocio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
    use SoftDeletes;

    protected $table = 'orden';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'sede_id',
		'cliente_id',
		'mediopago_id',
		'docnegocio_id',
		'serie',
		'numero',
		'fecha',
		'hora',
		'estadopago',
		'total',
		'canje',
		'ciclo_id',
		'citamedica_id',
		'token',
		'correo',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'cliente', 'docnegocio', 'mediopago');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Entidad::class, 'cliente_id');
    }

    public function docnegocio()
    {
        return $this->belongsTo(Docnegocio::class);
    }

    public function mediopago()
    {
        return $this->belongsTo(Mediopago::class);
    }
}
