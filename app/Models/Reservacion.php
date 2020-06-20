<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservacion extends Model
{
    use SoftDeletes;

    protected $table = 'reservacion';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'nombre',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at',
    ];
}
