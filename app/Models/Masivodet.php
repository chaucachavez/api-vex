<?php

namespace App\Models;

use App\Models\Masivo;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class Masivodet extends Model
{	 
    use SoftDeletes;

    protected $table = 'masivodet';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'idmasivo',
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
        return array('masivo', 'producto');
    } 

    //Relaciones
    public function masivo()
    {
        return $this->belongsTo(Masivo::class, 'idmasivo');
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
