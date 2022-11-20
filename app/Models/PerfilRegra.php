<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PerfilRegra extends Pivot
{
    protected $table = 'perfil_regra';

    const ID_PERFIL = 'id_perfil';
    const ID_REGRA = 'id_regra';
}
