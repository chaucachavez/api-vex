<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Diaxhora extends Model
{ 

    protected $table = 'diaxhora';
    protected $primaryKey = 'iddiaxhora';
    public $timestamps = false;
    
    protected $fillable = [  
    	'idsede',
    	'fecha',
    	'inicio',
    	'fin'
    ];

    public $filterWhere = [ 
    	'iddiaxhora',
    	'idsede',
    	'fecha',
    	'inicio',
    	'fin'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('sede');        
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }
}
