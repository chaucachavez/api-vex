<?php

namespace App\Models;

use App\Models\Llamadadet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timbrado extends Model
{
    use SoftDeletes;

    protected $table = 'timbrado';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'codigo',
		'nombre',
		'created_id',
		'updated_id ',
		'created_at',
		'updated_at '
    ];

    //Relaciones
    public function llamadasdetalles()
	{
		return $this->hasMany(Llamadadet::class);
	}
}
