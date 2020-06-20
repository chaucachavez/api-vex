<?php

namespace App\Models;

use App\Models\Entidad;
use App\Models\Camilla;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terapia extends Model
{
    use SoftDeletes;

    protected $table = 'terapia';
    protected $primaryKey = 'idterapia';
    protected $dates = ['deleted_at']; 

    protected $fillable = [ 
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede', 'camilla', 'paciente', 'terapeuta', 'terapeutajefe');
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    } 

    public function camilla()
    {
        return $this->belongsTo(Camilla::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function terapeuta()
    {
        return $this->belongsTo(Entidad::class, 'idterapista');
    }

    public function terapeutajefe()
    {
        return $this->belongsTo(Entidad::class);
    } 


}
