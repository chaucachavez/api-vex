<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{ 
    protected $table = 'departamento';    
 	protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
    	'id',
    	'nombre'
    ]; 

    public $filterWhere = [
        'id',
        'nombre'
    ]; 
}
