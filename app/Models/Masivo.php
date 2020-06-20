<?php

namespace App\Models;
use App\Models\Sede;
use App\Models\Venta;
use App\Models\Masivodet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Masivo extends Model
{   
    use SoftDeletes;

    protected $table = 'masivo'; 

    protected $fillable = [ 
        'idsede',
        'iddocumentofiscal',        
        'serie',
        'numerodel',      
        'numeroal',
        'idcliente',        
        'fechaemision', 
        'idestadodocumento',  
        'progreso',
        'cantidad',
        'estado',
        'exonerada',
        'inafecta',
        'gratuita',
        'gravada',
        'descuentoporcentaje',
        'descuentoglobal',
        'descuentoitem',
        'descuentototal',
        'valorimpuesto',
        'cargo',
        'totalimpuestobolsa',
        'total',
        'totalletra',
        'clientenombre',
        'clientedoc',
        'clientenumerodoc',
        'clientedireccion',
        'operacion',
        'moneda',
        'tipocambio',
        'fechavencimiento',
        'detraccion',
        'selvaproducto',
        'selvaservicio',
        'condicionpago',
        'observacion',
        'pdfformato',
        'pdf'
    ];

    public $filterWhere = [
        'id',
        'idempresa',
        'idsede',
        'fechaemision', 
        'iddocumentofiscal',
        'serie',
        'numerodel',      
        'numeroal',
        'progreso',
        'total'
    ];  
    
    // Recursos a solicitar
    public static function recursos() {
        return array('docnegocio', 'masivodet', 'sede', 'ventas', 'ventas.docnegocio');
    } 

    public static function whereRango() {
        return array('fechaemisionFrom', 'fechaemisionTo');
    }

    // Pertenece a una
    public function docnegocio()
    {
        return $this->belongsTo(Docnegocio::class, 'iddocumentofiscal');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }

    public function masivodet()
    {
        return $this->hasMany(Masivodet::class, 'idmasivo');
    } 

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idmasivo');
    }
}
