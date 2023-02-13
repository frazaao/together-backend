<?php

namespace Domain\Disciplina\Controllers;

use App\Policies\Policy;
use Domain\Disciplina\Models\Disciplina;
use Illuminate\Http\Request;

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
        $disciplinas = $this->disciplina->with("turma")->when(
            isset($_GET['page']),
            function ($q) {
                return $q->paginate();
            },
            function ($q) {
                return $q->get();
            }
        );

        return response()->json($disciplinas);
    }

    public function store(Request $request)
    {
        $disciplina = $this->disciplina->create($request->all());

        foreach ($request->id_turma as $idTurma) {
            $disciplina->turma()->attach($idTurma);
        }

        return response()->json($disciplina);
    }
}
