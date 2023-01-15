<?php

namespace Domain\TurmaDisciplina\Models;

use Domain\Disciplina\Models\Disciplina;
use Domain\Turma\Models\Turma;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TurmaDisciplina extends Pivot
{
    protected $table = "turma_disciplina";

    const ID = "id";
    const ID_DISCIPLINA = "id_disciplina";
    const ID_TURMA = "id_turma";

    protected $hidden = ['pivot'];

    public function turma()
    {
        return $this->hasMany(
            Turma::class,
            Turma::ID,
            TurmaDisciplina::ID_TURMA
        );
    }

    public function disciplina()
    {
        return $this->hasMany(
            Disciplina::class,
            Disciplina::ID,
            TurmaDisciplina::ID_DISCIPLINA
        );
    }
}
