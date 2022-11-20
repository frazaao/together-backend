<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario';

    const ID = 'id';
    const REGISTRO = 'registro';
    const NOME = 'nome';
    const EMAIL = 'email';
    const TELEFONE = 'telefone';
    const SENHA = 'senha';
    const ID_PERFIL = 'id_perfil';
    const ATIVO = 'ativo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        Usuario::REGISTRO,
        Usuario::NOME,
        Usuario::EMAIL,
        Usuario::TELEFONE,
        Usuario::SENHA,
        Usuario::ATIVO,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, Usuario::ID_PERFIL, Perfil::ID);
    }
}