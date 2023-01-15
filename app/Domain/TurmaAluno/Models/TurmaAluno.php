<?php

namespace Domain\TurmaAluno\Models;

use Domain\Aluno\Models\Aluno;
use Domain\Turma\Models\Turma;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TurmaAluno extends Pivot
{
    protected $table = "turma_aluno";

    const ID = "id";
    const ID_ALUNO = "id_aluno";
    const ID_TURMA = "id_turma";

    protected $hidden = ['pivot'];

    public function turma()
    {
        return $this->hasMany(
            Turma::class,
            Turma::ID,
            TurmaAluno::ID_TURMA
        );
    }

    public function aluno()
    {
        return $this->hasMany(
            Aluno::class,
            Aluno::ID,
            TurmaAluno::ID_ALUNO
        );
    }
}
