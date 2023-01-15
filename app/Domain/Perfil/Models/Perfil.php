<?php

namespace Domain\Perfil\Models;

use Domain\PerfilRegra\Models\PerfilRegra;
use Domain\Regra\Models\Regra;
use Domain\Usuario\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfil';

    const ID = 'id';
    const TITULO = 'titulo';
    const ATIVO = 'ativo';

    protected $fillable = [
        Perfil::TITULO,
        Perfil::ATIVO
    ];

    public function regra()
    {
        return $this->belongsToMany(
            Regra::class,
            PerfilRegra::class,
            PerfilRegra::ID_PERFIL,
            PerfilRegra::ID_REGRA
        );
    }

    public function usuario()
    {
        return $this->hasMany(
            Usuario::class,
            Usuario::ID_PERFIL,
            Perfil::ID
        );
    }
}
