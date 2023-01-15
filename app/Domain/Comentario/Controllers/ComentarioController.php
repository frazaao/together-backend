<?php

namespace Domain\Comentario\Controllers;

use App\Policies\Policy;
use App\Policies\RegrasEnum;
use Domain\Aluno\Models\Aluno;
use Domain\Comentario\Models\Comentario;
use Domain\Comentario\Validations\ComentarioValidations;
use Domain\Usuario\Models\Usuario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Policy
{
    private $comentario;
    private $aluno;
    private $usuario;
    private $listarComentariosFactory;

    public function __construct(
        Comentario $comentario,
        Aluno $aluno,
        Usuario $usuario,
        ListarComentariosFactory $listarComentariosFactory
    ) {
        $this->comentario = $comentario;
        $this->aluno = $aluno;
        $this->usuario = $usuario;
        $this->listarComentariosFactory = $listarComentariosFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comentarios = $this->listarComentariosFactory->listarComentarios();
        return response()->json($comentarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->temPermissao(RegrasEnum::COMENTARIO_CRIAR);

        $usuarioProfessor = $this->usuario->find(Auth::id());

        $comentario = $this->comentario->create([
            Comentario::ID_ALUNO => $request->id_aluno,
            Comentario::CONTEUDO => $request->conteudo,
            Comentario::ID_USUARIO_PROFESSOR => $usuarioProfessor->id
        ]);
        return response()->json($comentario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listarComentariosPorIdAluno($idAluno)
    {
        $this->temPermissao(RegrasEnum::COMENTARIO_VISUALIZAR);

        $comentarios = $this->comentario
            ->where(Comentario::ID_ALUNO, $idAluno)
            ->with(['professor', 'professor.perfil', 'aluno'])
            ->get();

        return response()->json($comentarios);
    }
}
