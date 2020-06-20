<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    protected $primaryKey = 'iddocumento';

    public $filterWhere = [
        'iddocumento', 
        'nombre',   
        'abreviatura',
        'codigosunat'
    ];
}
