<?php

namespace Domain\Aluno\Models;

use Domain\Nota\Models\Nota;
use Domain\Presenca\Models\Presenca;
use Domain\Turma\Models\Turma;
use Domain\TurmaAluno\Models\TurmaAluno;
use Domain\Usuario\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $table = "aluno";

    const ID = "id";
    const NOME = "nome";
    const ID_USUARIO_RESPONSAVEL = "id_usuario_responsavel";

    protected $fillable = [
        Aluno::NOME,
        Aluno::ID_USUARIO_RESPONSAVEL
    ];

    public function usuario_responsavel()
    {
        return $this->belongsTo(
            Usuario::class,
            Aluno::ID_USUARIO_RESPONSAVEL,
            Usuario::ID
        );
    }

    public function presenca()
    {
        return $this->hasMany(
            Presenca::class,
            Presenca::ID_ALUNO,
            Aluno::ID
        );
    }

    public function turma()
    {
        return $this->belongsToMany(
            Turma::class,
            TurmaAluno::class,
            TurmaAluno::ID_ALUNO,
            TurmaAluno::ID_TURMA
        );
    }

    public function nota()
    {
        return $this->hasMany(
            Nota::class,
            Nota::ID_ALUNO,
            Aluno::ID
        );
    }
}
