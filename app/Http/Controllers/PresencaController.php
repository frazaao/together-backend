<?php

namespace App\Http\Controllers;

use App\Exceptions\SistemaExeption;
use App\Models\Aluno;
use App\Models\Presenca;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PresencaController extends Controller
{

    private Aluno $aluno;
    private Presenca $presenca;

    public function __construct(Aluno $aluno, Presenca $presenca)
    {
        $this->aluno = $aluno;
        $this->presenca = $presenca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presencas = $this->presenca->with("aluno:" . Aluno::ID . "," . Aluno::NOME)->get();
        return response()->json($presencas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aluno = $this->aluno->find($request->id_aluno);
        if (!$aluno) {
            throw new SistemaExeption(
                "O atributo id_aluno deve ser um valor válido",
                Response::HTTP_NOT_FOUND
            );
        }
        $presenca = $aluno->presenca()->create($request->all());
        return response()->json($presenca);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idAluno
     * @return \Illuminate\Http\Response
     */
    public function showByIdAluno($idAluno)
    {
        $aluno = $this->aluno->with('presenca')->find($idAluno);
        if (!$aluno) {
            throw new SistemaExeption(
                "O atributo id_aluno deve ser um valor válido",
                Response::HTTP_NOT_FOUND
            );
        }
        $presencas = $aluno->presenca;
        return response()->json($presencas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presenca = $this->presenca->find($id);
        if (!$presenca) {
            throw new SistemaExeption(
                "Presença não encontrada",
                Response::HTTP_NOT_FOUND
            );
        }
        $presenca->delete();
        return response()->json();
    }
}
