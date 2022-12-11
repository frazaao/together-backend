<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Comentario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{

    protected $aluno;
    protected $usuario;
    protected $comentario;

    public function __construct(Comentario $comentario, Aluno $aluno, Usuario $usuario)
    {
        $this->aluno = $aluno;
        $this->usuario = $usuario;
        $this->comentario = $comentario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comentarios = $this->comentario->get();
        return response()->json($comentarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
