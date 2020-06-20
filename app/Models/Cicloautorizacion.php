<?php

namespace App\Models;

use App\Models\Cicloautorizacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cicloautorizacion extends Model
{	
	use SoftDeletes;

    protected $table = 'cicloautorizacion';
    protected $dates = ['deleted_at'];    

    protected $fillable = [
    	  'idcicloautorizacion',
        'idempresa',
        'idcicloatencion',
        'idsede',
        'fecha',
        'idestadoimpreso',
        'idaseguradora',
        'idproducto',
        'idpaciente',
        'idaseguradoraplan',
        'deducible',
        'idcoaseguro',
        'coaseguro',
        'idtipo',
        'codigo',
        'descripcion',
        'idtitular',
        'parentesco',
        'nombrecompania',
        'principal',
        'idventa',
    ];

    protected $hidden = [
        'pivot'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('productos');
    }

    public function productos() 
    {
    	return $this->belongsToMany(Producto::class, 'idproducto');
    } 
}
