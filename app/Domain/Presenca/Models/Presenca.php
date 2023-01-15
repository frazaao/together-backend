<?php

namespace Domain\Presenca\Models;

use Domain\Aluno\Models\Aluno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    use HasFactory;

    protected $table = 'presenca';

    const ID = 'id';
    const ID_ALUNO = "id_aluno";
    const PRESENCA = 'presenca';

    protected $fillable = [
        Presenca::ID_ALUNO,
        Presenca::PRESENCA
    ];

    public function aluno()
    {
        return $this->belongsTo(
            Aluno::class,
            Presenca::ID_ALUNO,
            Aluno::ID
        );
    }

    public function getPresencaAttribute(int $value): bool
    {
        return (bool)$value;
    }
}
