<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Docnegocio extends Model
{ 
    protected $table = 'documentofiscal'; 
    protected $primaryKey = 'iddocumentofiscal';

    protected $fillable = [
    	'nombre',
		'descripcion',
		'tipo',
		'codigosunat',
		'codigopse'
    ];
}
