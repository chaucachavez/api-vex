<?php

namespace App\Models;

use App\Models\Sede; 
use Illuminate\Database\Eloquent\Model; 

class Sedehorario extends Model
{
    // use SoftDeletes; 
    protected $table = 'sedehorario';
    protected $primaryKey = 'idsedehorario';
    public $timestamps = false;
    // protected $dates = ['deleted_at']; 

    protected $fillable = [  
        'idsede', 
        'tiempoconsultamedica',   
        'tiempointerconsulta',  
        'tiempoterapia',   
        'cronometroterapia',   
        'intervaloterapia',    
        'cantidadcamilla', 
        'luinicio',   
        'lufin',  
        'mainicio',    
        'mafin',
        'miinicio',
        'mifin',
        'juinicio',
        'jufin',
        'viinicio',
        'vifin',
        'sainicio',
        'safin',
        'doinicio',
        'dofin' 
    ];

    public $filterWhere = [
        'idsede'
    ];  

    //Recursos a solicitar
    public static function recursos() {
    	return array('sede');
    } 

    //Relaciones 

    public function Sede() 
    {
        return $this->belongsTo(Sede::class, 'idsede', 'idsede');
    } 
}
