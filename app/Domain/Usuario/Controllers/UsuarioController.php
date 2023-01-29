<?php

namespace Domain\Usuario\Controllers;

use App\Exceptions\SistemaExeption;
use App\Policies\Policy;
use App\Policies\RegrasEnum;
use Domain\Usuario\Requests\UsuarioStoreRequest;
use Domain\Usuario\Requests\UsuarioUpdateRequest;

use Domain\Usuario\Models\Usuario;
use Domain\Perfil\Models\Perfil;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Policy
{
    private Usuario $usuario;
    private Perfil $perfil;

    public function __construct(Usuario $usuario, Perfil $perfil)
    {
        $this->usuario = $usuario;
        $this->perfil = $perfil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->temPermissao(RegrasEnum::USUARIO_VISUALIZAR);

        $usuarios = $this->usuario->with([
            'perfil',
            'perfil.regra',
            'aluno',
            'turmaDisciplina.turma',
            'turmaDisciplina.disciplina'
        ])->get();

        return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioStoreRequest $request)
    {
        $this->temPermissao(RegrasEnum::USUARIO_CRIAR);

        $perfil = $this->perfil->findOrFail($request->id_perfil);

        $usuario = $perfil->usuario()->create([
            Usuario::NOME => $request->nome,
            Usuario::EMAIL => $request->email,
            Usuario::TELEFONE => $request->telefone,
            Usuario::SENHA => Hash::make($request->senha),
            Usuario::REGISTRO => $request->registro,
            Usuario::ATIVO => true
        ]);

        return response()->json($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->temPermissao(RegrasEnum::USUARIO_VISUALIZAR);

        $usuario = $this->usuario->with('perfil', 'perfil.regra')->find($id);

        if (!$usuario) {
            throw new SistemaExeption(
                "Usuário não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }
        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioUpdateRequest $request, $id)
    {
        $this->temPermissao(RegrasEnum::USUARIO_ATUALIZAR);

        $usuario = $this->usuario->find($id);

        if (!$usuario) {
            throw new SistemaExeption(
                "Usuário não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }

        $usuario->update($request->all());
        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->temPermissao(RegrasEnum::USUARIO_DELETAR);

        $usuario = $this->usuario->find($id);
        if (!$usuario) {
            throw new SistemaExeption(
                "Usuário não encontrado",
                Response::HTTP_NOT_FOUND
            );
        }

        $usuario->delete();
        return response()->json();
    }
}
