<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $header = 'X-name')
    {
        //Next es la barra entre el ANTES y DESPUES
        //return $next($request);
        $response = $next($request); 

        $response->headers->set($header, config('app.name'));

        return $response;
    }
}
    