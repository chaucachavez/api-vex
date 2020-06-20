<?php

namespace App\Models;

use App\Models\Citamedica;
use Illuminate\Database\Eloquent\Model; 

class Estadodocumento extends Model
{ 

    protected $table = 'estadodocumento';
    protected $primaryKey = 'idestadodocumento'; 
    public $timestamps = false;
     
    public $filterWhere = [
        'tipo',
        'nombre'
    ]; 

    //Recursos a solicitar
     
}
