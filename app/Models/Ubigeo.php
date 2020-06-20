<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = 'ubigeo';  
    protected $primaryKey = 'idubigeo'; 

    protected $fillable = [    	 
    	'idubigeo',
		'pais',
		'dpto',
		'prov',
		'dist',
        'nombre',
        'nacionalidad'
    ];

    public function getIdubigeoAttribute($valor) 
    {
        return $valor;
    } 
}
