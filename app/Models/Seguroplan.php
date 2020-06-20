<?php

namespace App\Models;

use App\Models\Modelo;
use App\Models\Seguro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguroplan extends Model
{
    use SoftDeletes;

    protected $table = 'seguroplan';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'seguro_id',
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
    	return array('seguro', 'modelos', 'usuarios');
    }
 
    //Relaciones
    public function seguro()
    {
        return $this->belongsTo(Seguro::class);
    }

    public function modelos() 
    {
        return $this->belongsToMany(Modelo::class);
    } 

    public function usuarios() 
    {
        return $this->belongsToMany(Entidad::class);
    } 
}
