<?php

namespace Domain\Comentario\Controllers;

use App\Policies\RegrasEnum;
use Domain\Aluno\Models\Aluno;
use Domain\Comentario\Models\Comentario;
use Domain\Comentario\Validations\ComentarioValidations;
use Domain\Usuario\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class ListarComentariosFactory extends ComentarioController
{
    private $comentario;
    private $comentarios;
    private $aluno;
    private $usuario;

    public function __construct(
        Comentario $comentario,
        Aluno $aluno,
        Usuario $usuario
    ) {
        $this->comentario = $comentario;
        $this->aluno = $aluno;
        $this->usuario = $usuario;
    }

    public function listarComentarios()
    {
        return $this
            ->listarComentariosDoAlunoPorResponsavelLogado()
            ->listarComentariosPorProfessorLogado()
            ->listarTodosComentarios()
            ->comentarios;
    }

    /**
     * listarTodosComentarios
     *
     * @return $this
     */
    public function listarTodosComentarios()
    {
        if ($this->possuiRegra(RegrasEnum::COMENTARIO_VISUALIZAR)) {
            $this->comentarios = $this->comentario
                ->with(['professor', 'professor.perfil', 'aluno'])
                ->when(
                    isset($_GET['page']),
                    function ($q) {
                        return $q->paginate(10);
                    },
                    function ($q) {
                        return $q->get();
                    }
                );
        }
        return $this;
    }

    /**
     * listarComentariosPorProfessorLogado
     *
     * @return $this
     */
    public function listarComentariosPorProfessorLogado()
    {
        if (ComentarioValidations::verificaSeUsuarioEProfessor(Auth::user())) {
            $this->comentarios = $this->comentario
                ->where(Comentario::ID_USUARIO_PROFESSOR, Auth::id())
                ->with(['professor', 'professor.perfil', 'aluno'])
                ->when(
                    isset($_GET['page']),
                    function ($q) {
                        return $q->paginate(10);
                    },
                    function ($q) {
                        return $q->get();
                    }
                );
        }
        return $this;
    }


    /**
     * listarComentariosDoAlunoPorResponsavelLogado
     *
     * @return $this
     */
    public function listarComentariosDoAlunoPorResponsavelLogado()
    {
        $idsAlunos = array_column(Auth::user()->aluno->toArray(), Aluno::ID);

        $this->comentarios = $this->comentario
            ->where(Comentario::ID_ALUNO, $idsAlunos)
            ->with(['professor', 'professor.perfil', 'aluno'])
            ->when(
                isset($_GET['page']),
                function ($q) {
                    return $q->paginate(10);
                },
                function ($q) {
                    return $q->get();
                }
            );

        return $this;
    }
}
