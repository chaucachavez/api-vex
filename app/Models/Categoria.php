<?php

namespace App\Models;
 
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Categoria extends Model
{	 
    use SoftDeletes;

    protected $table = 'categoria'; 
    protected $primaryKey = 'idcategoria';
    
    protected $fillable = [  
    	'idempresa',
        'codigo',
    	'nombre',
    	'id_created_at' // Productosimport
    ];

    public $filterWhere = [
        'idcategoria', 
        'nombre'
    ];  

    // Recursos a solicitar
    public static function recursos() {
    	return array('productos');
    }

    // Relaciones
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idcategoria');
    } 
}
