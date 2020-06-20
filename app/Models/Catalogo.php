<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{ 

    protected $table = 'catalogo';
    protected $primaryKey = 'codigo';
    public $timestamps = false;
 	protected $keyType = 'string';
    
    protected $fillable = [
    	'codigo',
    	'nombre'
    ]; 

    public $filterWhere = [
        'codigo',
    	'nombre'
    ];
}
