<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 

class Logacceso extends Model
{ 

    protected $table = 'logacceso'; 
    protected $primaryKey = 'idlogacceso';
    public $timestamps = false;

    protected $fillable = [
        'identidad',
        'fechain',
        'horain',
        'token',
        'tokenstatus',
        'ip',
        'navegador',
        'fechaout',
        'horaout' 
    ];

    public $filterWhere = [];

    //Recursos a solicitar
    public static function recursos() {
        return array('usuario');
    }

    public static function whereRango() {
        return array('fechainFrom', 'fechainTo');
    }

    //Relaciones 
}
