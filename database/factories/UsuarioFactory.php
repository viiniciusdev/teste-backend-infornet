<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;


class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('123456'), // senha padrão para testes
        ];
    }
}