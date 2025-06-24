<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Redireciona se a requisição não for autenticada.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            abort(401, 'Não autorizado.');
        }

    
    }
}
