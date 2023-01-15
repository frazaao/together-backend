<?php

namespace Domain\TurmaDisciplinaUsuario\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TurmaDisciplinaUsuario extends Pivot
{
    protected $table = "turma_disciplina_usuario";

    const ID = "id";
    const ID_TURMA_DISCIPLINA = "id_turma_disciplina";
    const ID_USUARIO_PROFESSOR = "id_usuario_professor";
}
