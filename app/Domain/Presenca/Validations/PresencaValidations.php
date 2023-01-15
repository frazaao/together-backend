<?php

namespace Domain\Presenca\Validations;

use App\Exceptions\SistemaExeption;
use Domain\Aluno\Models\Aluno;
use Domain\Presenca\Models\Presenca;
use Illuminate\Http\Response;

class PresencaValidations
{
    private $aluno;

    public function __construct(Aluno $aluno)
    {
        $this->aluno = $aluno;
    }

    public function validateIfAlunoExists($idAluno)
    {
        $aluno = $this->aluno->find($idAluno);

        if (!$aluno) {
            throw new SistemaExeption(
                [
                    Presenca::ID_ALUNO => "O atributo id_aluno deve ser um valor válido"
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
