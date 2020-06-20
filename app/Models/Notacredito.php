<?php

namespace App\Models;

use App\Models\Entidad;
use App\Models\Venta;
use App\Models\Docnegocio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notacredito extends Model
{
    use SoftDeletes;

    protected $table = 'notacredito';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'venta_id',
		'docnegocio_id',
		'afiliado_id',
		'tipo',
		'fecha',
		'serie',
		'numero',
		'valorcredito',
		'valoraplicado',
		'valorpendiente',
		'descripcion',
		'medio',
		'codigo',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('afiliado', 'docnegocio', 'venta');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function afiliado()
    {
        return $this->belongsTo(Entidad::class, 'afiliado_id');
    }

    public function docnegocio()
    {
        return $this->belongsTo(Docnegocio::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
