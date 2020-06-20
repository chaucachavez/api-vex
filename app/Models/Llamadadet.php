<?php

namespace App\Models;

use App\Models\Anexo;
use App\Models\Llamada;
use App\Models\Timbrado;
use Illuminate\Database\Eloquent\Model;

class Llamadadet extends Model
{ 

    protected $table = 'llamadadet'; 

    protected $fillable = [
		'llamada_id',
		'timbrado_id',
		'anexo_id',
		'codigo',
		'fechahora',
		'fecha',
		'hora',
		'ano',
		'mes',
		'semana',
		'tipo',
		'origen',
		'destino',
		'desvio',
		'estado',
		'duracion',
		'costominuto',
		'costobolsa',
		'costototal' 
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('timbrado', 'llamada', 'anexo');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function timbrado()
    {
        return $this->belongsTo(Timbrado::class);
    }

    public function llamada()
    {
        return $this->belongsTo(Llamada::class);
    }

    public function anexo()
    {
        return $this->belongsTo(Anexo::class);
    }
}
