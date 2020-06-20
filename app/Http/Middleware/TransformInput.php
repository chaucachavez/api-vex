<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $modelo)
    {   
     
        $request->request->add(['empresa_id' => Config::get('constants.empresas.osi')]);
      
        foreach ($request->request->all() as $input => $value) {
            # code...
        }

        //Next es la barra entre el ANTES y DESPUES
        return $next($request);
    }
}
