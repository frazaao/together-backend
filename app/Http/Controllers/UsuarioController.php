<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Models\Perfil;
use App\Models\Usuario;
use Error;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    protected $usuario;

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
        $usuarios = $this->usuario->with('perfil', 'perfil.regra')->get();
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
        dd($request->validated());
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
        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario = $this->usuario->find($id);
        if (!$usuario) {
            throw new Error('Usuário não encontrado', Response::HTTP_NOT_FOUND);
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
        //
    }
}
