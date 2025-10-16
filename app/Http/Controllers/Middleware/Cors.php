<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Cabeceras CORS comunes
        $headers = [
            'Access-Control-Allow-Origin'      => '*', // Permitir CUALQUIER origen
            'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Content-Type, X-Auth-Token, Origin, Authorization, X-Requested-With',
        ];

        // 2. Manejo de la Petición OPTIONS (Pre-vuelo)
        // Si el método es OPTIONS, respondemos 200 inmediatamente.
        if ($request->isMethod('OPTIONS')) {
            return response('OK', 200)
                ->withHeaders($headers);
        }

        // 3. Procesar la petición real
        $response = $next($request);

        // 4. Asegurar que las cabeceras CORS se añadan a la respuesta final
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
