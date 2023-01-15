<?php

namespace Domain\Disciplina\Controllers;

use App\Policies\Policy;
use Domain\Disciplina\Models\Disciplina;

class DisciplinaController extends Policy
{
    private Disciplina $disciplina;

    public function __construct(
        Disciplina $disciplina
    ) {
        $this->disciplina = $disciplina;
    }

    public function index()
    {
        $disciplinas = $this->disciplina->with("turma")->get();

        return response()->json($disciplinas);
    }
}
