<?php

namespace App\Models;

use App\Models\Citamedica;
use App\Scopes\ClienteScope; 

class Cliente extends Entidad
{
    protected static function boot(){
		parent::boot();

		static::addGlobalScope(new ClienteScope);
	}

    public function citasmedicas()
    {
    	return $this->hasMany(Citamedica::class, 'paciente_id');
    }
 
}
