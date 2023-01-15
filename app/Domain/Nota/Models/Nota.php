<?php

namespace Domain\Nota\Models;

use Domain\Aluno\Models\Aluno;
use Domain\Disciplina\Models\Disciplina;
use Domain\Turma\Models\Turma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = "nota";

    const ID = "id";
    const VALOR = "valor";
    const ID_ALUNO = "id_aluno";
    const ID_DISCIPLINA = "id_disciplina";
    const ID_TURMA = "id_turma";
    const SEMESTRE = "semestre";

    protected $fillable = [
        Nota::VALOR,
        Nota::ID_ALUNO,
        Nota::ID_DISCIPLINA,
        Nota::ID_TURMA,
        Nota::SEMESTRE,
    ];

    public function aluno()
    {
        return $this->hasMany(
            Aluno::class,
            Aluno::ID,
            Nota::ID_ALUNO
        );
    }

    public function disciplina()
    {
        return $this->hasMany(
            Disciplina::class,
            Disciplina::ID,
            Nota::ID_DISCIPLINA
        );
    }

    public function turma()
    {
        return $this->hasMany(
            Turma::class,
            Turma::ID,
            Nota::ID_TURMA
        );
    }
}
