<?php

namespace App\Models;
 
use App\Models\Citamedica;
use App\Scopes\MedicoScope;
  

class Medico extends Entidad
{	

	protected static function boot(){
		parent::boot();

		static::addGlobalScope(new MedicoScope);
	}

    public function citasmedicas()
    {
    	return $this->hasMany(Citamedica::class);
    }
}
