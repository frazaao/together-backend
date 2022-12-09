<?php

namespace App\Http\Requests;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UsuarioStoreRequest extends FormRequest
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
            Usuario::TELEFONE . "required" => "O atributo required é obrigatório"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true,
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
