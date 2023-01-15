<?php

namespace Domain\Turma\Models;

use Domain\Aluno\Models\Aluno;
use Domain\Disciplina\Models\Disciplina;
use Domain\TurmaAluno\Models\TurmaAluno;
use Domain\TurmaDisciplina\Models\TurmaDisciplina;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $table = "turma";

    const ID = "id";
    const TITULO = "titulo";
    const ID_ESCOLA = "id_escola";

    protected $fillable = [
        Turma::TITULO,
        Turma::ID_ESCOLA
    ];

    protected $hidden = ['pivot'];

    public function escola()
    {
        //empty
    }

    public function disciplina()
    {
        return $this->belongsToMany(
            Disciplina::class,
            TurmaDisciplina::class,
            TurmaDisciplina::ID_TURMA,
            TurmaDisciplina::ID_DISCIPLINA
        )->using(TurmaDisciplina::class);
    }

    public function aluno()
    {
        return $this->belongsToMany(
            Aluno::class,
            TurmaAluno::class,
            TurmaAluno::ID_TURMA,
            TurmaAluno::ID_ALUNO
        );
    }
}
