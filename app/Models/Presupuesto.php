<?php

namespace App\Models;

use App\Models\Presupuestodet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuesto extends Model
{
    use SoftDeletes;

    protected $table = 'presupuesto';
    protected $primaryKey = 'idpresupuesto';
    protected $dates = ['deleted_at'];

    //Recursos a solicitar
    public static function recursos() {
    	return array('detalle');
    }

    //Relaciones
    public function detalle()
    {
        return $this->hasMany(Presupuestodet::class, 'idpresupuesto');
    }


}
