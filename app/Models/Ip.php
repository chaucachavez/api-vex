<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Ip extends Model
{ 

    protected $table = 'ip'; 
    protected $primaryKey = 'idip';
    public $timestamps = false;

    protected $fillable = [ 
		'nombre' 
    ];

    public $filterWhere = [  
    	'nombre'
    ];
}
