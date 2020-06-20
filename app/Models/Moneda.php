<?php

namespace App\Models;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Model; 

class Moneda extends Model
{ 

    protected $table = 'moneda'; 
    protected $primaryKey = 'idmoneda';
 	public $timestamps = false;
 	protected $keyType = 'string';
 	
 	public $filterWhere = [
 		'idmoneda'
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('comprobantes');
    } 

    //Relaciones 
    public function comprobantes() {
        return $this->hasMany(Venta::class, 'moneda');
    }
}
