<?php

namespace App\Models;

use App\Models\Venta;
use App\Models\Mediopago;
use App\Models\Notacredito;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{ 
    protected $table = 'pago'; 

    protected $fillable = [
    	'venta_id',
		'mediopago_id',
		'monto',
		'notacredito_id',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('venta', 'mediopago', 'notacredito');
    } 

    //Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function mediopago()
    {
        return $this->belongsTo(Mediopago::class);
    }

    public function notacredito()
    {
        return $this->belongsTo(Notacredito::class);
    }
 
}
