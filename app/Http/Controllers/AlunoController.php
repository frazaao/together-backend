<?php

namespace App\Http\Controllers;

use App\Exceptions\SistemaExeption;
use App\Http\Requests\AlunoStoreRequest;
use App\Http\Requests\AlunoUpdateRequest;
use App\Models\Aluno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlunoController extends Controller
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
        $alunos = $this->aluno->get();
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
