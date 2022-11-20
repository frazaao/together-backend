<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    use HasFactory;

    protected $table = 'regra';

    const ID = 'id';
    const REGRA = 'regra';
    const ATIVO = 'ativo';

    protected $fillable = [
        Regra::REGRA,
        Regra::ATIVO
    ];

    public function perfil()
    {
        return $this->belongsToMany(Perfil::class)->using(PerfilRegra::class);
    }
}
