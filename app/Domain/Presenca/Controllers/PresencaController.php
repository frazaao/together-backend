<?php

namespace Domain\Presenca\Controllers;

use App\Policies\Policy;
use App\Policies\RegrasEnum;
use Domain\Aluno\Models\Aluno;
use Domain\Presenca\Models\Presenca;
use Domain\Presenca\Requests\PresencaStoreRequest;
use Domain\Presenca\Validations\PresencaValidations;

class PresencaController extends Policy
{

    private Aluno $aluno;
    private Presenca $presenca;
    private PresencaValidations $presencaValidations;

    public function __construct(
        Aluno $aluno,
        Presenca $presenca,
        PresencaValidations $presencaValidations
    ) {
        $this->aluno = $aluno;
        $this->presenca = $presenca;
        $this->presencaValidations = $presencaValidations;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->temPermissao(RegrasEnum::PRESENCA_VISUALIZAR);

        $presencas = $this->presenca->with("aluno:" . Aluno::ID . "," . Aluno::NOME)->get();
        return response()->json($presencas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresencaStoreRequest $request)
    {
        // $this->temPermissao(RegrasEnum::PRESENCA_CRIAR);

        $aluno = $this->aluno->find($request->id_aluno);

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
        // $this->temPermissao(RegrasEnum::PRESENCA_VISUALIZAR);

        $this->presencaValidations->validateIfAlunoExists($idAluno);

        $aluno = $this->aluno->with('presenca')->find($idAluno);

        $presencas = $aluno->presenca;

        return response()->json($presencas);
    }
}
