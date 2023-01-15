<?php

namespace Domain\Disciplina\Models;

use Domain\Turma\Models\Turma;
use Domain\TurmaDisciplina\Models\TurmaDisciplina;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $table = 'disciplina';

    const ID = 'id';
    const TITULO = 'titulo';

    protected $fillable = [
        Disciplina::TITULO,
    ];

    protected $hidden = ['pivot'];

    public function turma()
    {
        return $this->belongsToMany(
            Turma::class,
            TurmaDisciplina::class,
            TurmaDisciplina::ID_DISCIPLINA,
            TurmaDisciplina::ID_TURMA
        );
    }
}
