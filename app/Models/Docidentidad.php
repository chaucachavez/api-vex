<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docidentidad extends Model
{ 

    protected $table = 'docidentidad'; 

    protected $fillable = [
    	'nombre',
		'abreviatura',
    ];
}
