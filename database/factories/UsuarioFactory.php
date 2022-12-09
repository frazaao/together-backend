<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            Usuario::REGISTRO => '',
            Usuario::NOME => $this->faker->name(),
            Usuario::EMAIL => $this->faker->unique()->safeEmail(),
            Usuario::TELEFONE => $this->faker->phoneNumber(),
            Usuario::SENHA => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            Usuario::ATIVO => true
        ];
    }
}
