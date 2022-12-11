<?php

namespace App\Http\Controllers;

use App\Exceptions\SistemaExeption;
use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
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
        $usuarios = $this->usuario->with('perfil', 'perfil.regra', 'aluno')->get();
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
        $perfil = $this->perfil->findOrFail($request->id_perfil);

        $usuario = $perfil->usuario()->create([
            Usuario::NOME => $request->nome,
            Usuario::EMAIL => $request->email,
            Usuario::TELEFONE => $request->telefone,
            Usuario::SENHA => $request->senha,
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
