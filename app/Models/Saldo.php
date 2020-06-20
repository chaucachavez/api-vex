<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Ciclo;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saldo extends Model
{
    use SoftDeletes;

    protected $table = 'saldo';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'sede_id',
		'tipo',
		'fecha',
		'monto',
		'numero',
		'ciclo_id',
		'cicloref_id',
		'idventa',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'ciclo', 'cicloref');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function cicloref()
    {
        return $this->belongsTo(Ciclo::class, 'cicloref_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
