<?php

namespace Domain\Relatorio\Controllers;

use App\Policies\Policy;
use Domain\Aluno\Models\Aluno;
use Domain\Turma\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;

class RelatorioController extends Policy
{
    private Aluno $aluno;
    private Turma $turma;

    public function __construct(Aluno $aluno, Turma $turma)
    {
        $this->aluno = $aluno;
        $this->turma = $turma;
    }

    public function __invoke(Request $request)
    {
        $values = DB::select(
            "SELECT
            turma.titulo AS turma,
            aluno.nome AS aluno,
            COUNT(distinct presenca.id) AS presencas,
            disciplina.titulo AS disciplina,
            nota.valor AS nota,
            nota.trimestre AS bimestre
            FROM turma
            LEFT JOIN turma_aluno
            ON turma.id = turma_aluno.id_turma
            LEFT JOIN aluno
            ON turma_aluno.id_aluno = aluno.id
            LEFT JOIN turma_disciplina
            ON turma_disciplina.id_turma = turma.id
            LEFT JOIN disciplina
            ON disciplina.id = turma_disciplina.id_disciplina
            LEFT JOIN nota
            ON nota.id_aluno = aluno.id AND disciplina.id = nota.id_disciplina
            LEFT JOIN presenca
            ON presenca.id_aluno = aluno.id AND presenca.presenca = TRUE

            GROUP BY aluno, turma, disciplina, nota, bimestre"
        );

        $config = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => "Considerando a lista de campos de uma model laravel (turma, aluno, presenca, nota, disciplina, bimestre) gere uma configuração json do Vega-lite v5 (sem campo de dados) me retornando apenas o json que atenda a seguinte solicitação: $request->question",
            'max_tokens' =>  1500
        ])->choices[0]->text;


        $config = str_replace("\n", "", $config);
        $json_init = strpos($config, '{');
        $json_end = strripos($config, '}');
        $sub_config = substr($config, $json_init, ($json_end - $json_init + 1));
        $json_config = json_decode($sub_config, true);


        return response()->json([
            "values" => $values,
            "config" => $json_config
        ]);
    }
}
