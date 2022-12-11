<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $table = "aluno";

    const ID = "id";
    const NOME = "nome";
    const ID_USUARIO_RESPONSAVEL = "id_usuario_responsavel";

    protected $fillable = [
        Aluno::NOME,
        Aluno::ID_USUARIO_RESPONSAVEL
    ];

    public function usuario_responsavel()
    {
        return $this->belongsTo(
            Usuario::class,
            Aluno::ID_USUARIO_RESPONSAVEL,
            Usuario::ID
        );
    }

    public function presenca()
    {
        return $this->hasMany(
            Presenca::class,
            Presenca::ID_ALUNO,
            Aluno::ID
        );
    }
}
