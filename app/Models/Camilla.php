<?php

namespace App\Models;

use App\Models\Sede;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camilla extends Model
{
    use SoftDeletes;

    protected $table = 'camilla';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'sede_id',
		'nombre',
		'activo',
		'created_id',
		'updated_id',		
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede');
    }

    public static function whereRango() {
        return array('fecha');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
