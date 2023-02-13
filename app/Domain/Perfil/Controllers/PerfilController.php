<?php

namespace Domain\Perfil\Controllers;

use App\Policies\Policy;
use Domain\Perfil\Models\Perfil;

class PerfilController extends Policy
{

    private Perfil $perfil;

    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
    }

    public function index()
    {
        $perfis = $this->perfil->with('regra')->when(
            isset($_GET['page']),
            function ($q) {
                return $q->paginate(10);
            },
            function ($q) {
                return $q->get();
            }
        );

        return response()->json($perfis);
    }
}
