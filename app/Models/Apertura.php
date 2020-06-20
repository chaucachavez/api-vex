<?php

namespace App\Models;

use App\Models\Caja;
use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Venta;
use App\Models\Citamedica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apertura extends Model
{
    use SoftDeletes;

    protected $table = 'apertura';    
    protected $primaryKey = 'idapertura';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'sede_id',
		'caja_id',
		'estado',
		'tcdolar',
		'personalopen_id',
		'fechaopen',
		'personalclose_id',
		'fechaclose',
		'visalote',
		'mastercardlote',
		'saldoinicial',
		'totalefectivo',
		'totaltarjeta',
		'totalsoles',
		'totaldolares',
		'totalvisa',
		'totalmastercard',
		'total',
		'diferencia',
		'created_id',
		'updated_id',		
		'created_at',
		'updated_at',
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'caja', 'personalopen', 'personalclose', 'personalopen', 'ventas', 'citamedicas', 'cajachicas');
    }

    public static function whereRango() {
        return array('fechaopenFrom', 'fechaopenTo', 'fechacloseFrom', 'fechacloseTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function personalopen()
    {
        return $this->belongsTo(Entidad::class, 'personalopen_id');
    }

    public function personalclose()
    {
        return $this->belongsTo(Entidad::class, 'personalclose_id');
    }
    
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    } 

    public function citamedicas()
    {
        return $this->hasMany(Citamedica::class);
    } 

    public function cajachicas()
    {
        return $this->hasMany(Citamedica::class);
    }  
}
