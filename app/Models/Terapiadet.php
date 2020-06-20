<?php

namespace App\Models;

use App\Models\Ciclo;
use App\Models\Terapia;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terapiadet extends Model
{
    use SoftDeletes;

    protected $table = 'terapiatratamiento';
    protected $primaryKey = 'idterapiatratamiento';
    protected $dates = ['deleted_at']; 

    protected $fillable = [ 
    ];

    //Recursos a solicitar
    public static function recursos() {
    	return array('terapia', 'ciclo', 'producto');
    }

    //Relaciones
    public function terapia()
    {
        return $this->belongsTo(Terapia::class, 'idterapia');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'idcicloatencion');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
