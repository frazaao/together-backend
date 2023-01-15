<?php

namespace Domain\Aluno\Requests;

use App\Http\Requests\BaseRequest;
use Domain\Aluno\Models\Aluno;
use Domain\Usuario\Models\Usuario;
use Illuminate\Validation\Rule;

class AlunoStoreRequest extends BaseRequest
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
            Aluno::NOME => "string|required|min:5",
            Aluno::ID_USUARIO_RESPONSAVEL => [
                'integer',
                'required',
                Rule::exists(Usuario::class, Usuario::ID)
            ]
        ];
    }

    public function messages()
    {
        return [
            Aluno::NOME . ".required" => "O atributo nome é obrigatório",
            Aluno::NOME . ".min" => "O atributo nome deve conter no mínimo 5 caracteres",
            Aluno::ID_USUARIO_RESPONSAVEL . ".required" => "O atributo id_usuario_responsavel é obrigatório",
            Aluno::ID_USUARIO_RESPONSAVEL . ".exists" => "O atributo id_usuario_responsavel deve ser um valor válido"
        ];
    }
}
