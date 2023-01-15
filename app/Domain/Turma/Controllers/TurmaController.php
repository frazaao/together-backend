<?php

namespace Domain\Turma\Controllers;

use App\Policies\Policy;
use Domain\Turma\Models\Turma;

class TurmaController extends Policy
{
    private Turma $turma;

    public function __construct(
        Turma $turma
    ) {
        $this->turma = $turma;
    }

    public function index()
    {
        $turmas = $this->turma->with("disciplina", "aluno")->get();

        return response()->json($turmas);
    }
}
