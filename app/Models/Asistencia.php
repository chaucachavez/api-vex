<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    use SoftDeletes;

    protected $table = 'asistencia';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'personal_id',
		'fecha',
		'ingreso',
		'tipo',
		'sede_id',
		'salida',
		'tiempo',
		'ipingreso',
		'ipsalida',
		'created_id',
		'updated_id',
		'created_at',
		'updated_at', 
    ];

    //Recursos a solicitar
    public static function recursos() 
    {
    	return array('sede', 'personal');
    }

    public static function whereRango() 
    {
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

}
