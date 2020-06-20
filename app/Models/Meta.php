<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{ 

    protected $table = 'meta'; 

    protected $fillable = [
    	'sede_id',
		'producto_id',
		'ano',
		'enero',
		'febrero',
		'marzo',
		'abril',
		'mayo',
		'junio',
		'julio',
		'agosto',
		'setiembre',
		'octubre',
		'noviembre',
		'diciembre',
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
