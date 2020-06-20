<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Consultorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    // use SoftDeletes;

    protected $table = 'horariomedico';
    protected $primaryKey = 'idhorariomedico';
    public $timestamps = false;
    // protected $dates = ['deleted_at']; 

    protected $fillable = [
        'idhorariomedico',
    	'idempresa',
        'idsede', 
        'idmedico',
        'idconsultorio',
        'fecha', 
        'inicio', 
        'fin',
        'tipo'
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'personal', 'consultorio');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function personal()
    {
        return $this->belongsTo(Entidad::class, 'personal_id');
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }

    public static function medicosPorHorario($param) {
   
        $data = \DB::table('horariomedico')                 
                ->join('entidad', 'horariomedico.idmedico', '=', 'entidad.identidad')
                ->join('entidadperfil', 'entidad.identidad', '=', 'entidadperfil.identidad')
                ->join('perfil', 'entidadperfil.idperfil', '=', 'perfil.idperfil')
                ->select('horariomedico.idmedico', 'entidad.entidad', 'entidad.maxcamilla')
                ->where($param) 
                ->orderBy('entidad.entidad', 'ASC')
                ->distinct()
                ->get(); 

        return $data;        
    }
}
