<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Seguro extends Model
{ 

    protected $table = 'aseguradora';
    protected $primaryKey = 'idaseguradora';

    protected $fillable = [  
    ];

    public $filterWhere = [ 
    ];
}
