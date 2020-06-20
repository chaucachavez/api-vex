<?php

namespace App\Models;

use App\Models\Sede; 
use Illuminate\Database\Eloquent\Model; 

class Turnoterapia extends Model
{ 
    protected $table = 'turnoterapia';
    protected $primaryKey = 'idturnoterapia'; 

    public $filterWhere = [
        'idsede' 
    ];  

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede');
    } 

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    } 
}
