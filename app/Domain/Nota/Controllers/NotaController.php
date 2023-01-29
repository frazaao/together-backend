<?php

namespace Domain\Nota\Controllers;

use App\Policies\Policy;
use Domain\Aluno\Models\Aluno;
use Domain\Nota\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Policy
{

    private Nota $nota;
    private Aluno $aluno;

    public function __construct(Nota $nota, Aluno $aluno)
    {
        $this->nota = $nota;
        $this->aluno = $aluno;
    }

    public function listarNotasPorIdAluno(int $idAluno)
    {
        $notas = $this->aluno->with('nota', 'nota.disciplina')->find($idAluno);

        return response()->json($notas);
    }

    public function createNota(Request $request)
    {
        $nota = $this->nota->create($request->all());

        return response()->json($nota);
    }
}
