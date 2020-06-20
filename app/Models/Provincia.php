<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{ 
    protected $table = 'provincia';    
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
