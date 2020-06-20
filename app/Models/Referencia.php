<?php

namespace App\Models;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referencia extends Model
{
    use SoftDeletes;

    protected $table = 'referenciacita';
    protected $primaryKey = 'idreferenciacita';  
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'idempresa',
		'nombre' 
    ];

    public $filterWhere = [
        'idempresa',
        'nombre'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('empresa');
    } 

    //Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
