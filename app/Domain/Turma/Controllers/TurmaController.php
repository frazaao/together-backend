<?php

namespace Domain\Turma\Controllers;

use App\Policies\Policy;
use Domain\Turma\Models\Turma;
use Illuminate\Http\Request;

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
        $turmas = $this->turma->with("disciplina", "aluno")->when(
            isset($_GET['page']),
            function ($q) {
                return $q->paginate();
            },
            function ($q) {
                return $q->get();
            }
        );

        return response()->json($turmas);
    }

    public function store(Request $request)
    {
        $request['id_escola'] = 1;
        $turma = $this->turma->create($request->all());

        return response()->json($turma);
    }
}
