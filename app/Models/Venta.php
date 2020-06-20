<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\User;
use App\Models\Ciclo;
use App\Models\Moneda;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Factura;
use App\Models\Apertura;
use App\Models\Ventadet;
use App\Models\Ventapago;
use App\Models\Docnegocio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Venta extends Model
{
    use SoftDeletes;

    protected $table = 'venta';
    protected $primaryKey = 'idventa';
    protected $dates = ['deleted_at']; 

    protected $fillable = [ 	
      'idsede',
      'iddocumentofiscal',
      'serie',
      'numero',         
      'idcliente',          
      'idturno',
      'fechaemision',         
      'idestadodocumento',
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
      'pagado',
      'vuelto',
      'descripcion',
      'clientenombre',
      'clientedoc',
      'clientenumerodoc',
      'clientedireccion',
      'cuentadetraccion',
      'motivoanulacion',       
      'idpersonalanula',       
      'tiponc',
      'documentonc',
      'serienc',
      'numeronc',            
      'operacion',
      'moneda',
      'tipocambio',
      'fechavencimiento',
      'detraccion',
      'selvaproducto',
      'selvaservicio', 
      'ordencompra',
      'guiaremitente',
      'guiatransportista',
      'placavehiculo',
      'condicionpago',
      'observacion',
      'pdfformato',
      'cpecorreo',
      'sendcorreo',
      'sunat_aceptado',
      'sunat_nota',       
      'qr',
      'hash',
      'pdf',
      'xml',
      'cdr',
      'sunat_anulado_ticket',
      'sunat_anulado_aceptado',
      'sunat_anulado_key',
      'sunat_anulado_nota',
      'enlace',
      'idmasivo'
    ];

    public $filterWhere = [
        'idventa',
        'idcliente',
        'fechaemision',
        'idestado',
        'idsede',
        'idestadodocumento', 
        'idafiliado', 
        'iddocumentofiscal',
        'serie',
        'idcaja',
        'numero',
        'idmasivo'
    ];

    // Recursos a solicitar
    public static function recursos() {
    	return array('empresa', 'sede', 'afiliado', 'docnegocio', 'cliente', 'cliente.documento', 'turno', 'ciclo', 'personalrevision', 'ventadet', 'ventadet.producto', 'ventapago', 'factura', 'creacion', 'modificacion', 'money');
    }

    public static function whereRango() {
        return array('fechaemisionFrom', 'fechaemisionTo', 'fechapagoFrom', 'fechapagoTo');
    }

    // Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }

    public function afiliado()
    {
        return $this->belongsTo(Entidad::class, 'idafiliado');
    }

    public function docnegocio()
    {
        return $this->belongsTo(Docnegocio::class, 'iddocumentofiscal');
    }

    public function cliente()
    {
        return $this->belongsTo(Entidad::class, 'idcliente');
    }

    public function turno()
    {
      //Se amarra al turno de vendedores.
        // return $this->belongsTo(Apertura::class, 'idapertura');
    }

    public function money()
    {
        return $this->belongsTo(Moneda::class, 'moneda');
    }

    public function ciclo()
    { 
        // dd('jc');
        return $this->belongsTo(Ciclo::class, 'idcicloatencion');
    }

    public function personalrevision()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function ventadet()
    {
        return $this->hasMany(Ventadet::class, 'idventa', 'idventa');
    } 

    public function ventapago()
    {
        return $this->hasMany(Ventapago::class, 'idventa', 'idventa');
    } 

    public function factura()
    {
        return $this->hasOne(Factura::class, 'idventa');
    } 

    public function creacion()
    {
        return $this->belongsTo(User::class, 'id_created_at');
    }

    public function modificacion()
    {
        return $this->belongsTo(User::class, 'id_updated_at');
    } 

}
