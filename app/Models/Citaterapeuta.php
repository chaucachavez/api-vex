<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citaterapeuta extends Model
{
    use SoftDeletes;

    protected $table = 'citaterapeutica';
    protected $primaryKey = 'idcitaterapeutica';
    protected $dates = ['deleted_at']; 

    protected $fillable = [ 

    ];

    public $filterWhere = [
        'idcitaterapeutica',
        'idpaciente',
        'fecha',
        'idestado',
        'idsede'
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('terapeuta', 'paciente', 'sede');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function terapeuta()
    {
        return $this->belongsTo(Entidad::class, 'idterapista');
    }

    public function paciente()
    {
        return $this->belongsTo(Entidad::class, 'idpaciente');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }
}
