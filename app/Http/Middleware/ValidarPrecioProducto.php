<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidarPrecioProducto
{
    public function handle(Request $request, Closure $next): Response
    {
        $precio = $request->input('precio');

        if ($precio !== null && (!is_numeric($precio) || (float) $precio <= 0)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'precio' => 'El precio debe ser un número mayor que cero.',
                ]);
        }

        return $next($request);
    }
}