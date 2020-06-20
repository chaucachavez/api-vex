<?php

namespace App\Models;

use App\Models\Llamadadet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anexo extends Model
{
    use SoftDeletes;

    protected $table = 'anexo';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'codigo',
		'nombre',
		'activo',
		'created_id',
		'updated_id',
		'created_at',
		'updated_at'
    ];

    public function llamadasdetalles()
	{
		return $this->hasMany(Llamadadet::class);
	}
}
