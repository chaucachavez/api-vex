<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Mediopago extends Model
{ 

    protected $table = 'mediopago';
    protected $dates = ['deleted_at']; 

    protected $fillable = [    
        'idmediopago',   
        'nombre' 
    ];

    public $filterWhere = [
    	'idmediopago',
    	'nombre'
    ];

    //Recursos a solicitar
}
