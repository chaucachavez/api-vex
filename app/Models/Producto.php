<?php

namespace App\Models;

use App\Models\Meta;
use App\Models\Unidad;
use App\Models\Catalogo;
use App\Models\Servicio;
use App\Models\Ventadet;
use App\Models\Categoria;
use App\Models\Tarifario;
use App\Models\Tratamiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Producto extends Model
{   
    use SoftDeletes;

    protected $table = 'producto';
    protected $primaryKey = 'idproducto';

	const PRODUCTO_DISPONIBLE = '1';
	const PRODUCTO_NO_DISPONIBLE = '0';

    protected $fillable = [  
        'idempresa', 
        'unidadmedida', 
        'idcategoria',
        'codigo',
        'nombre',      
        'moneda',
        'imgportada',
        'costocompra',
        'valorcompra', 
        'costoventa',
        'valorventa',
        'idimpuesto',
        'stock',                
        'codigosunat',
        'destacado'
    ];

    public $filterWhere = [
        'idproducto',
        'idempresa',  
        'nombre', 
        'moneda',
        'idcategoria', 
        'valorventa',
        'destacado',
        'idimpuesto',
        'codigo'
    ]; 
  

    public function estaDisponible() 
    {
    	return $this->activo == Producto::PRODUCTO_DISPONIBLE; 
    }

    //Recursos a solicitar
    public static function recursos() {
        return array('categoria', 'metas', 'tarifas', 'servicios', 'tratamientos', 'unidad', 'ventas', 'catalogo');
    } 

    //de 1 a muchos
    public function metas() 
    {
    	return $this->hasMany(Meta::class);
    }

    //tiene muchas
	public function tarifas()
	{
		return $this->hasMany(Tarifario::class, 'idproducto');
	}    

	//requiere de muchos
    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    } 

    //Pertenece a una
    public function categoria() 
    { 
        return $this->belongsTo(Categoria::class, 'idcategoria');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidadmedida');
    }

    public function ventas()
    {
        return $this->hasMany(Ventadet::class, 'idproducto');
    } 

    public function catalogo() 
    { 
        return $this->belongsTo(Catalogo::class, 'codigosunat');
    }
}

