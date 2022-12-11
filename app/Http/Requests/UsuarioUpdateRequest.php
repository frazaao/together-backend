<?php

namespace App\Http\Requests;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Validation\Rule;

class UsuarioUpdateRequest extends BaseRequest
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
            Usuario::NOME => "nullable|min:5",
            Usuario::EMAIL => "nullable",
            Usuario::TELEFONE => "nullable|min:10|max:11",
            Usuario::SENHA => "nullable|min:8",
            Usuario::ID_PERFIL => [
                "nullable",
                Rule::exists(Perfil::class, Perfil::ID)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            Usuario::NOME . ".min" => "O atributo nome precisa ter no mínimo 5 caracteres",
            Usuario::TELEFONE . ".min" => "O atributo telefone deve conter no mínimo 10 dígitos",
            Usuario::TELEFONE . ".max" => "O atributo telefone deve conter no máximo 11 dígitos",
            Usuario::SENHA . ".min" => "A senha deve conter no mínimo 8 caracteres",
            Usuario::ID_PERFIL . ".exists" => "O atributo id_perfil deve ser um valor válido"
        ];
    }
}
