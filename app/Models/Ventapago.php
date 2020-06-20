<?php

namespace App\Models;

use App\Models\Venta; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class Ventapago extends Model
{	 
    use SoftDeletes;

    protected $table = 'ventapago';
    protected $primaryKey = 'idventapago';
    protected $dates = ['deleted_at']; 

    protected $fillable = [ 
        'idventa',
        'idmediopago',
        'importe',        
        'nota' 
    ]; 

    //Recursos a solicitar
    public static function recursos() {
        return array('venta');
    } 

    //Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa');
    } 
}
