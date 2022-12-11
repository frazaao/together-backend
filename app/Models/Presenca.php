<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    use HasFactory;

    protected $table = 'presenca';

    const ID = 'id';
    const ID_ALUNO = "id_aluno";

    protected $fillable = [
        Presenca::ID_ALUNO
    ];

    public function aluno()
    {
        return $this->belongsTo(
            Aluno::class,
            Presenca::ID_ALUNO,
            Aluno::ID
        );
    }
}
