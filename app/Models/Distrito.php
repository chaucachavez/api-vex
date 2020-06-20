<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{ 
    protected $table = 'distrito';    
 	protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
    	'id',
        'codigo',
    	'nombre'
    ]; 

    public $filterWhere = [
        'id',
        'codigo',
        'nombre'
    ]; 
}
