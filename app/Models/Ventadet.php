<?php

namespace App\Models;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class Ventadet extends Model
{	 
    use SoftDeletes;

    protected $table = 'ventadet';
    protected $primaryKey = 'idventadet';

    protected $fillable = [ 
        'idventa',
        'idproducto',
        'cantidad',        
        'idunidadmedida',
        'idimpuesto',
        'valorunit',
        'valordescuento',
        'valorventa',
        'impuestobolsa',
        'montototalimpuestos',
        'preciounit',
        'codigocupon',
        'descuento',
        'total',
        'codigo',
        'codigosunat',
        'nombre',
        'descripcion'
    ]; 

    //Recursos a solicitar
    public static function recursos() {
        return array('venta', 'producto');
    } 

    //Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa');
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
