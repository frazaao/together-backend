<?php

namespace Domain\Aluno\Controllers;

use App\Exceptions\SistemaExeption;
use App\Policies\Policy;
use App\Policies\RegrasEnum;
use Domain\Aluno\Requests\AlunoStoreRequest;
use Domain\Aluno\Requests\AlunoUpdateRequest;

use Domain\Aluno\Models\Aluno;
use Domain\Usuario\Models\Usuario;

use Illuminate\Http\Response;

class AlunoController extends Policy
{
    private Aluno $aluno;
    private Usuario $usuario;

    public function __construct(Aluno $aluno, Usuario $usuario)
    {
        $this->aluno = $aluno;
        $this->usuario = $usuario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->temPermissao(RegrasEnum::ALUNO_VISUALIZAR);

        $alunos = $this->aluno->with('turma.disciplina')->get();
        return response()->json($alunos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlunoStoreRequest $request)
    {
        $this->temPermissao(RegrasEnum::ALUNO_CRIAR);

        $usuario_responsavel = $this->usuario->find(
            $request->id_usuario_responsavel
        );

        $aluno = $usuario_responsavel->aluno()->create($request->all());
        return response()->json($aluno);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->temPermissao(RegrasEnum::ALUNO_VISUALIZAR);

        $aluno = $this->aluno->with('usuario_responsavel')->find($id);
        if (!$aluno) {
            throw new SistemaExeption(
                "Aluno não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }
        return response()->json($aluno);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlunoUpdateRequest $request, $id)
    {
        $this->temPermissao(RegrasEnum::ALUNO_ATUALIZAR);

        $aluno = $this->aluno->find($id);
        if (!$aluno) {
            throw new SistemaExeption(
                "Aluno não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }
        $aluno->update($request->all());
        return response()->json($aluno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->temPermissao(RegrasEnum::ALUNO_DELETAR);

        $aluno = $this->aluno->find($id);
        if (!$aluno) {
            throw new SistemaExeption(
                "Aluno não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }
        $aluno->delete();
        return response()->json();
    }
}
