<?php

namespace App\Models;

use App\Models\Seguroplan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model
{
    use SoftDeletes;

    protected $table = 'modelo';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'nombre',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];

    protected $hidden = [
        'pivot'
    ];

    //Recursos a solicitar
    public static function recursos() {
        return array('seguroplanes');
    }

    //Relaciones
    public function seguroplanes() 
    {
        return $this->belongsToMany(Seguroplan::class);
    } 
}
