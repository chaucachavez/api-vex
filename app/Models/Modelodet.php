<?php

namespace App\Models;

use App\Models\Modelo;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelodet extends Model
{
    use SoftDeletes;

    protected $table = 'modelodet';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'modelo_id',
		'producto_id',
		'nombre',
		'precio',
		'codigo',
		'cantidad',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('modelo', 'producto');
    } 

    //Relaciones
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
