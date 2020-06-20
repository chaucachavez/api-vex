<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class Tarifario extends Model
{  
    protected $table = 'tarifario'; 

    protected $fillable = [
    	'sede_id',
		'producto_id',
		'precioalto',
		'preciomedio',
		'preciobajo',
		'precioproalto',
		'preciopromedio',
		'precioprobajo',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'producto');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
