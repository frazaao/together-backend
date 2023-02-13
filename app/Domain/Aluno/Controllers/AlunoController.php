<?php

namespace Domain\Aluno\Controllers;

use App\Exceptions\SistemaExeption;
use App\Policies\Policy;
use App\Policies\RegrasEnum;
use Domain\Aluno\Requests\AlunoStoreRequest;
use Domain\Aluno\Requests\AlunoUpdateRequest;

use Domain\Aluno\Models\Aluno;
use Domain\Turma\Models\Turma;
use Domain\Usuario\Models\Usuario;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

        $alunos = $this->aluno
            ->with(['turma', 'turma.disciplina'])
            ->when(
                isset($_GET['turma']),
                function ($q) {
                    return $q->whereHas('turma', function ($query) {
                        $query->where('turma.id', $_GET['turma']);
                    });
                }
            )
            ->when(
                isset($_GET['page']),
                function ($q) {
                    return $q->paginate(10);
                },
                function ($q) {
                    return $q->get();
                }
            );
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
        // $this->temPermissao(RegrasEnum::ALUNO_CRIAR);

        DB::beginTransaction();
        try {
            $usuario_responsavel = $this->usuario->find(
                $request->id_usuario_responsavel
            );

            $aluno = $usuario_responsavel->aluno()->create($request->all());

            $aluno->turma()->attach($request->id_turma);

            DB::commit();

            return response()->json($aluno);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new SistemaExeption($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $this->temPermissao(RegrasEnum::ALUNO_VISUALIZAR);

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
        // $this->temPermissao(RegrasEnum::ALUNO_ATUALIZAR);

        $aluno = $this->aluno->find($id);
        if (!$aluno) {
            throw new SistemaExeption(
                "Aluno não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }
        $aluno->update($request->all());
        $aluno->save();
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
