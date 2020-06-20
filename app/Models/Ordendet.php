<?php

namespace App\Models;

use App\Models\Orden;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class Ordendet extends Model
{ 
    protected $table = 'ordendet'; 

    protected $fillable = [
    	'orden_id',
		'producto_id',
		'cantidad',
		'preciounit',
		'total',
		'cupon',
		'descuento',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('producto', 'orden');
    } 

    //Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
}
