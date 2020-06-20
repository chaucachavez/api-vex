<?php

namespace App\Models;

use App\Models\venta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{ 
    // use SoftDeletes;

    protected $table = 'ventafactura'; 
    protected $primaryKey = 'idfactura'; 

    protected $fillable = [
    	 
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('venta');
    } 

    //Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa');
    }
}
