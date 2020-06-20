<?php

namespace App\Models;

use App\Models\Entidad;
use App\Models\Producto;
use App\Models\Citamedica;
use Illuminate\Database\Eloquent\Model; 

class Tratamiento extends Model
{ 
    protected $table = 'tratamientomedico'; 
    protected $primaryKey = 'idtratamientomedico';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idcitamedica',
        'idmedico',
        'parent',
        'parentcantidad',
        'idproducto',
        'cantidad'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('producto', 'personal', 'citamedica', 'productoparent');
    } 

    //Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    } 

    public function productoparent()
    {
        return $this->belongsTo(Producto::class, 'parent');
    } 

    public function personal()
    {
    	//Deberia salir un error de user_id
        return $this->belongsTo(Entidad::class);
    } 

    public function citamedica()
    {
        //Deberia salir un error de user_id
        return $this->belongsTo(Citamedica::class);
    } 
}
