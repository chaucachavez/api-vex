<?php

namespace App\Models;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuestodet extends Model
{
    use SoftDeletes;

    protected $table = 'presupuestodet';
    protected $primaryKey = 'idpresupuestodet';
    protected $dates = ['deleted_at'];

    //Recursos a solicitar
    public static function recursos() {
    	return array('producto');
    }

    //Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    } 
}
