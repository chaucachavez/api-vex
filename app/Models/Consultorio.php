<?php

namespace App\Models;

use App\Models\Sede;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultorio extends Model
{
    use SoftDeletes;

    protected $table = 'consultorio';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'sede_id',
		'nombre',
		'ubicacion',
		'created_id',
		'updated_id',
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
