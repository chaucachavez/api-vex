<?php

namespace App\Models;

use App\Models\Citamedica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen extends Model
{
    use SoftDeletes;

    protected $table = 'examen';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'nombre',
		'created_id',
		'updated_id',
		'created_at',
		'updated_at',
    ];

    protected $hidden = [
        'pivot'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('citasmedicas');        
    }

    //Relaciones
    public function citasmedicas()
    {
        return $this->belongsToMany(Citamedica::class);
    } 
}
