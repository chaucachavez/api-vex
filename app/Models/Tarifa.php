<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarifa extends Model
{
    // use SoftDeletes;

    protected $table = 'tarifamedico';
    protected $primaryKey = 'idtarifamedico';
    public $timestamps = false;
    // protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'idsede',
		'idmedico',
		'idproducto',
		'preciounit' 
    ];

    public $filterWhere = [
        'idtarifamedico',
        'idsede',
        'idmedico',
        'idproducto',
        'preciounit'
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'personal', 'producto');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }

    public function personal()
    {
        return $this->belongsTo(Entidad::class, 'idmedico');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
