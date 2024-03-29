<?php

namespace Domain\Auth\Controllers;

use App\Exceptions\SistemaExeption;
use App\Policies\Policy;
use Domain\Usuario\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Policy
{
    private Usuario $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }
    /**
     * Authenticate the user in API
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->senha
        ])) {
            throw new SistemaExeption(
                "Erro ao autenticar no sistema, verifique seu email e senha",
                Response::HTTP_UNAUTHORIZED
            );
        }

        Auth::user()->tokens()->delete();
        $token = Auth::user()->createToken('token');
        return response()->json(["token" => $token->plainTextToken]);
    }

    public function me()
    {
        $usuario = $this->usuario->with('perfil', 'aluno')->find(Auth::id());
        return response()->json($usuario);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(["ok" => true]);
    }
}
