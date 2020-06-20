<?php

namespace App\Models;

use App\Models\Ciclo;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciclodet extends Model
{
    use SoftDeletes;

    protected $table = 'ciclodet';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'ciclo_id',
		'producto_id',
		'tipoprecio',
		'cantidadmedico',
		'cantidadcliente',
		'preciounitalto',
		'totalalto',
		'preciounitmedio',
		'totalmedio',
		'preciounitbajo',
		'totalbajo',
		'cantidadpagada',
		'cantidadefectuado',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('ciclo', 'producto');
    } 

    //Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }
}
