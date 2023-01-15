<?php

namespace Domain\Usuario\Requests;

use App\Http\Requests\BaseRequest;
use Domain\Perfil\Models\Perfil;
use Domain\Usuario\Models\Usuario;
use Illuminate\Validation\Rule;

class UsuarioStoreRequest extends BaseRequest
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
            Usuario::NOME => "required|min:5",
            Usuario::EMAIL => "required",
            Usuario::TELEFONE => "required|min:10|max:11",
            Usuario::SENHA => "required|min:8",
            Usuario::ID_PERFIL => [
                "required",
                Rule::exists(Perfil::class, Perfil::ID)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            Usuario::NOME . ".required" => "O atributo nome é obrigatório",
            Usuario::NOME . ".min" => "O atributo nome precisa ter no mínimo 5 caracteres",
            Usuario::EMAIL . ".required" => "O atributo email é obrigatório",
            Usuario::TELEFONE . ".required" => "O atributo telefone é obrigatório",
            Usuario::TELEFONE . ".min" => "O atributo telefone deve conter no mínimo 10 dígitos",
            Usuario::TELEFONE . ".max" => "O atributo telefone deve conter no máximo 11 dígitos",
            Usuario::SENHA . ".required" => "O atributo senha é obrigatório",
            Usuario::SENHA . ".min" => "A senha deve conter no mínimo 8 caracteres",
            Usuario::ID_PERFIL . ".required" => "O atributo id_perfil é obrigatório",
            Usuario::ID_PERFIL . ".exists" => "O atributo id_perfil deve ser um valor válido"
        ];
    }
}
