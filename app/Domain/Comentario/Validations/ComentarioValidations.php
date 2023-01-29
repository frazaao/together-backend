<?php

namespace Domain\Comentario\Validations;

use Domain\Aluno\Models\Aluno;
use Domain\Comentario\Models\Comentario;
use Domain\Usuario\Models\Usuario;

class ComentarioValidations
{
    private $comentario;
    private $aluno;
    private $usuario;

    const ID_PERFIL_PROFESSOR = 2;

    public function __construct(
        Comentario $comentario,
        Aluno $aluno,
        Usuario $usuario
    ) {
        $this->comentario = $comentario;
        $this->aluno = $aluno;
        $this->usuario = $usuario;
    }

    /**
     * verificaSeUsuarioEProfessor
     *
     * @param  Usuario $usuario
     * @return bool
     */
    public static function verificaSeUsuarioEProfessor(Usuario $usuario): bool
    {
        if ($usuario->perfil->id === self::ID_PERFIL_PROFESSOR) {
            return true;
        }

        return false;
    }
}
