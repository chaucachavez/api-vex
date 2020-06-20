<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Ciclo;
use App\Models\Seguro;
use App\Models\Producto;
use App\Models\Seguroplan;
use App\Models\Tipoautorizacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autorizacion extends Model
{
    use SoftDeletes;

    protected $table = 'autorizacion';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'ciclo_id',
		'sede_id',
		'seguro_id',
		'cubierto',
		'producto_id',
		'seguroplan_id',
		'tipoautorizacion_id',
		'fecha',
		'codigo',
		'deducible',
		'coaseguro',
		'descripcion',
		'created_id',
		'updated_id',		
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() 
    {
    	return array('ciclo', 'tipoautorizacion', 'sede', 'seguroplan', 'seguro', 'producto', 'ciclo.sede', 'ciclo.paciente');
    }

    public static function whereRango() 
    {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

	public function tipoautorizacion()
    {
        return $this->belongsTo(Tipoautorizacion::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function seguroplan()
    {
        return $this->belongsTo(Seguroplan::class);
    }

    public function seguro()
    {
        return $this->belongsTo(Seguro::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
