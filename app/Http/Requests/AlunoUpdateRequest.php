<?php

namespace App\Http\Requests;

use App\Models\Aluno;
use App\Models\Usuario;
use Illuminate\Validation\Rule;

class AlunoUpdateRequest extends BaseRequest
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
            Aluno::NOME => "nullable|min:5",
            Aluno::ID_USUARIO_RESPONSAVEL => [
                'nullable',
                Rule::exists(Usuario::class, Usuario::ID)
            ]
        ];
    }

    public function messages()
    {
        return [
            Aluno::NOME . "min" => "O atributo nome deve conter no mínimo 5 caracteres",
            Aluno::ID_USUARIO_RESPONSAVEL . "exists" => "O atributo id_usuario_responsavel deve ser um valor válido"
        ];
    }
}
