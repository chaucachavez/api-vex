<?php

namespace App\Models;

use App\Models\User;
use App\Models\Perfil;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class EmpresaUsers extends Model
{	
	// https://es.stackoverflow.com/questions/136492/laravel-y-las-tablas-pivote
	
    protected $table = 'empresa_users';

	public $timestamps = true;

	protected $fillable = [
		'iduser'
	];

	public $filterWhere = [
		'iduser'	
	];

	//Recursos a solicitar
    public static function recursos() {
        return array('usuario', 'empresa', 'perfil', 'usuario.sedes');
    }

    //Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'iduser');
    }
 	
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa');
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'idempresa');
    }
}
