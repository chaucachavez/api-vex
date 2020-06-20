<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{ 

    protected $table = 'unidad';
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

    protected $hidden = [
        'pivot'
    ];
}
