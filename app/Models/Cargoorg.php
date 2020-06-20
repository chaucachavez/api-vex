<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargoorg extends Model
{
    protected $table = 'cargoorg';
    protected $primaryKey = 'idcargoorg';

    public $filterWhere = [
        'idcargoorg', 
        'idempresa',   
        'nombre' 
    ];
}
