<?php

namespace App\Models;

use App\Models\Venta;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Distrito;
use App\Models\Sedehorario;
use App\Models\Departamento;
use App\Models\Documentoserie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Sede extends Model
{
    use SoftDeletes;

    protected $table = 'sede';
    protected $primaryKey = 'idsede'; 

    protected $fillable = [  
        'nombre',
        'abreviatura',
        'comercial',
        'direccion',
        'ubigeo',
        'departamento',
        'provincia',
        'distrito',
        'codigosunat',
        'pdffactura',
        'pdfboleta',
        'pdfcabecera',
        'pdfnombre',
        'pdfcolor', 
        'imgcpe'
    ];

    public $filterWhere = [
        'idsede',
        'idempresa',
        'nombre',    
        'direccion',          
        'codigosunat',
        'pdffactura',
        'pdfboleta',
        'estado',
    ]; 

    protected $hidden = [
        'pivot'
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('empresa', 'usuarios', 'sedehorario', 'comprobantes.documentofiscal', 'ventas');
    } 

    //Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa');
    }

    public function usuarios() 
    {
        return $this->belongsToMany(Entidad::class, 'entidadsede', 'idsede', 'identidad');
    }

    public function sedehorario()
    { 
        return $this->hasOne(Sedehorario::class, 'idsede', 'idsede');
    } 

    public function comprobantes() 
    {
        return $this->hasMany(Documentoserie::class, 'idsede');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idsede');
    }
}
