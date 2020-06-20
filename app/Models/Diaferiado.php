<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Diaferiado extends Model
{ 

    protected $table = 'diaferiado';
    protected $primaryKey = 'iddiaferiado';
    public $timestamps = true;

    protected $fillable = [  
    	'fecha'
    ];

    public $filterWhere = [ 
    	'iddiaferiado',
    	'fecha'
    ];
}
