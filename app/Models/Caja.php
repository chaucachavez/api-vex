<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caja extends Model
{
    use SoftDeletes;

    protected $table = 'caja';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'sede_id',
		'nombre',
		'created_id',
		'updated_id',
		'created_at',
		'updated_at',
    ];

    protected $hidden = [
        'pivot',
        'deleted_id',
        'deleted_at'
    ]; 

    //Recursos a solicitar
    public static function recursos() {
        return array('sede', 'usuarios');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function usuarios() 
    {
        return $this->belongsToMany(Entidad::class);
    }
}
