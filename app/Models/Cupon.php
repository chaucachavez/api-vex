<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cupon extends Model
{
    use SoftDeletes;

    protected $table = 'cupon';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'empresa_id',
		'codigo',
		'valor',
		'created_id',
		'updated_id', 
		'created_at',
		'updated_at	',
    ];

}
