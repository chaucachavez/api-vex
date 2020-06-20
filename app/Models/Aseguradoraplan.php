<?php

namespace App\Models;

use App\Models\Seguro;
use Illuminate\Database\Eloquent\Model;

class Aseguradoraplan extends Model
{
    protected $table = 'aseguradoraplan';
    protected $primaryKey = 'idaseguradoraplan';
    public $timestamps = false;

    protected $fillable = [  
        'idaseguradora', 
        'nombre',   
        'idcliente',  
        'cubierto',   
        'reservacita' 
    ];

    public $filterWhere = [
    	'nombre',  
    	'cubierto',   
        'reservacita' 
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('seguro');
    } 

    //Relaciones
    public function seguro()
    {
        return $this->belongsTo(Seguro::class, 'idaseguradora');
    }

}
