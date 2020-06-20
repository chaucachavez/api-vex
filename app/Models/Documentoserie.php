<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Docnegocio;
use Illuminate\Support\Facades\DB;
use App\Events\DocumentoserieCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documentoserie extends Model
{
    use SoftDeletes;

    protected $table = 'documentoserie';
    protected $primaryKey = 'iddocumentoserie';
    protected $dates = ['deleted_at'];

    protected $fillable = [ 
        'idempresa',
        'idsede',
        'iddocumentofiscal',
        'serie',
        'numero',
        'contingencia'
    ];

    public $filterWhere = [
        'idsede',
        'iddocumentofiscal'
    ];  

    // protected $dispatchesEvents = [
    //     "created" => DocumentoserieCreated::class 
    // ];
    
    //Recursos a solicitar
    public static function recursos() {
        return array('sede', 'documentofiscal');        
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }
 
    public function documentofiscal()
    {
        return $this->belongsTo(Docnegocio::class, 'iddocumentofiscal');
    }
 
}
