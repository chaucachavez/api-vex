<?php

namespace App\Models;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{ 
    protected $table = 'servicio'; 

    protected $fillable = [
    	'producto_id',
		'producto_idparent',
		'cantidad',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('producto', 'parent');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function parent()
    {
        return $this->belongsTo(Producto::class, 'parent_id');
    }
}
