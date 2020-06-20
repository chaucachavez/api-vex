<?php

namespace App\Models;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paselibre extends Model
{
    use SoftDeletes;

    protected $table = 'paselibre';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'sede_id',
		'cliente_id',
		'personal_id',
		'fecha',
		'descripcion',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('cliente', 'personal');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function cliente()
    {
        return $this->belongsTo(Entidad::class, 'cliente_id');
    }

    public function personal()
    {
        return $this->belongsTo(Entidad::class, 'personal_id');
    }
}
