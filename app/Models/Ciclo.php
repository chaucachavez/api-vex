<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Venta;
use App\Models\Citamedica;
use App\Models\Presupuesto;
use App\Models\Cicloautorizacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciclo extends Model
{
    use SoftDeletes;

    protected $table = 'cicloatencion';
    protected $primaryKey = 'idcicloatencion';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	 
    ];

    public $filterWhere = [
        'idcicloatencion',
        'idmedico',
        'idpaciente',
        'fecha',
        'idestado',
        'idsede'
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'medico', 'paciente', 'personaltraslado', 'sedetraslado', 'citasmedica.medico', 'terapiadetalle.terapia', 'terapiadetalle.terapia.terapeuta','terapiadetalle.producto', 'ventas.docnegocio', 'presupuesto.detalle.producto', 'autorizaciones');
    }

    public static function whereRango() {
        return array('fechaaperturaFrom', 'fechaaperturaTo', 'fechacierreFrom', 'fechacierreTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    } 

    public function medico()
    {
        return $this->belongsTo(Entidad::class, 'idmedico');
    }

    public function paciente()
    {
        return $this->belongsTo(Entidad::class, 'idpaciente');
    }

    public function personaltraslado()
    {
        return $this->belongsTo(Entidad::class, 'personaltraslado_id');
    }

    public function sedetraslado()
    {
        return $this->belongsTo(Entidad::class, 'sedetraslado_id');
    }

    public function citasmedica()
    {
        return $this->hasMany(Citamedica::class, 'idcicloatencion');
    } 

    public function terapiadetalle()
    {
        return $this->hasMany(Terapiadet::class, 'idcicloatencion');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idcicloatencion');
    } 

    public function presupuesto()
    {
        return $this->hasOne(Presupuesto::class, 'idcicloatencion');
    } 

    public function autorizaciones()
    {
        return $this->hasMany(Cicloautorizacion::class, 'idcicloatencion');
    } 
    
    
}
