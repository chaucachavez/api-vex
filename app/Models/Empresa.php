<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\User;
use App\Models\Venta;
use App\Models\Masivo;
use App\Models\Modulo;
use App\Models\Unidad;
use App\Models\Entidad;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Documentoserie;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{	 

    protected $table = 'empresa';
    protected $primaryKey = 'idempresa';

    protected $fillable = [
    	'url',
    	'nombre',
		'ruc',
		'razonsocial',
		'direccion',
		'telefono',
		'celular',
		'email',
		'ctadetraccion', 
		'logopdf',
        'logocuadrado',
		'preciounitario', 
		'tipocambio', 
		'tipocambiovalor', 
		'tipocalculo', 
		'mediopago', 
		'recargoconsumo', 
		'recargoconsumovalor', 
		'productoselva', 
		'servicioselva',
		// 'ambiente' 
    ];

    protected $hidden = [
        'pivot'
    ];

    public $filterWhere = [
        'idempresa', 
        'nombre'
    ]; 
    
    //Recursos a solicitar
    public static function recursos() {
        return array('modulos', 'sedes', 'usuarios', 'categorias', 'comprobantes', 'entidades', 'masivos', 'medidas', 'productos', 'ventas');
    }

    //Relaciones
    public function modulos() {
    	return $this->belongsToMany(Modulo::class, 'moduloempresa', 'idempresa', 'idmodulo');
    }
 	
 	public function sedes() {
    	return $this->hasMany(Sede::class, 'idempresa');
    }

    public function usuarios() {
        return $this->hasMany(User::class, 'idempresa');
    }

    public function categorias() {
        return $this->hasMany(Categoria::class, 'idempresa');
    }

    public function comprobantes() {
        return $this->hasMany(Documentoserie::class, 'idempresa');
    }

    public function entidades() {
        return $this->hasMany(Entidad::class, 'idempresa');
    }

    public function masivos() {
        return $this->hasMany(Masivo::class, 'idempresa');
    }

    public function medidas() {
        return $this->belongsToMany(Unidad::class, 'unidadempresa', 'idempresa', 'codigo');
    }

    public function productos() {
        return $this->hasMany(Producto::class, 'idempresa');
    }

    public function ventas() {
        return $this->hasMany(Venta::class, 'idempresa');
    }

}
