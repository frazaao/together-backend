<?php

namespace Domain\Presenca\Requests;

use App\Http\Requests\BaseRequest;
use Domain\Aluno\Models\Aluno;
use Domain\Presenca\Enums\PresencaResponseEnums;
use Domain\Presenca\Models\Presenca;
use Illuminate\Validation\Rule;

class PresencaStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Presenca::ID_ALUNO => [
                'integer',
                'required',
                Rule::exists(Aluno::class, Aluno::ID)
            ],
            Presenca::PRESENCA => [
                'boolean',
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            Presenca::ID_ALUNO . ".required" => PresencaResponseEnums::ID_ALUNO_E_OBRIGATORIO,
            Presenca::ID_ALUNO . ".exists" => PresencaResponseEnums::ID_ALUNO_NAO_EXISTE
        ];
    }
}
