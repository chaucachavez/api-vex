<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table = 'hora';
    protected $primaryKey = 'idhora';

    public $filterWhere = [
        'idhora',   
        'nombre',
        'tipo'
    ];

    public function getIdhoraAttribute($valor) 
    {
        return $valor;
    } 

}
