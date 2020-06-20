<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ano extends Model
{
    use SoftDeletes;

    protected $table = 'ano';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
    	'ano',
    	'empresa_id',
		'activo',
		'created_id',
		'updated_id',
		'created_at',
		'updated_at', 
    ];
}
