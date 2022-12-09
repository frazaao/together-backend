<?php

namespace Database\Seeders;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Usuario::factory(10)->has(Perfil::factory()->count(1))->create();
    }
}
