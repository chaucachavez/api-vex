<?php

namespace App\Models;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Llamada extends Model
{
    use SoftDeletes;

    protected $table = 'llamada';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'personal_id',
		'cantidad',
		'fecharegistro',
		'horaregistro',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('personal');
    }

    public static function whereRango() {
        return array('fecharegistroFrom', 'fecharegistroTo');
    }

    //Relaciones
    public function personal()
    {
        return $this->belongsTo(Entidad::class, 'personal_id');
    }
}
