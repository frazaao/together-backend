<?php

namespace Domain\Comentario\Models;

use Domain\Aluno\Models\Aluno;
use Domain\Usuario\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentario';

    const ID = 'id';
    const CONTEUDO = 'conteudo';
    const ID_ALUNO = 'id_aluno';
    const ID_USUARIO_PROFESSOR = 'id_usuario_professor';

    protected $fillable = [
        Comentario::CONTEUDO,
        Comentario::ID_ALUNO,
        Comentario::ID_USUARIO_PROFESSOR
    ];

    public function aluno()
    {
        return $this->belongsTo(
            Aluno::class,
            Comentario::ID_ALUNO,
            Aluno::ID
        );
    }

    public function professor()
    {
        return $this->belongsTo(
            Usuario::class,
            Comentario::ID_USUARIO_PROFESSOR,
            Usuario::ID
        );
    }
}
