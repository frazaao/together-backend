<?php

namespace App\Policies;

use App\Exceptions\SistemaExeption;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Policy extends Controller
{
    public function possuiRegra(string $regra): bool
    {
        $regras = array_column(Auth::user()->perfil->regra->toArray(), "regra");
        return in_array($regra, $regras);
    }

    public function temPermissao(string $regra)
    {
        if (!$this->possuiRegra($regra)) {
            $this->semPermissao();
        }
    }

    public function semPermissao()
    {
        throw new SistemaExeption(
            "Você não tem permissão para executar essa ação",
            Response::HTTP_FORBIDDEN
        );
    }
}
