<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historia extends Model
{
    use SoftDeletes;

    protected $table = 'historiaclinica';
    protected $primaryKey = 'idhistoriaclinica';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'idpaciente',
		'idsede',
		'hc' 
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'paciente');
    }
 
    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    } 

    public function paciente()
    {
        return $this->belongsTo(Entidad::class, 'idpaciente');
    }
}
