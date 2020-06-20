<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Superperfil extends Model
{ 
    protected $table = 'superperfil'; 

    protected $fillable = [
    	'nombre',
		'descripcion',
    ];
}
