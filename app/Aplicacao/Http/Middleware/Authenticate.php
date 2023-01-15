<?php

namespace App\Http\Middleware;

use App\Exceptions\SistemaExeption;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        throw new SistemaExeption(
            "Você não tem permissão para executar essa ação",
            Response::HTTP_FORBIDDEN
        );
    }
}
