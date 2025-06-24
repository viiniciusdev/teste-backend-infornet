<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servico>
 */
class ServicoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->word(), // ex: "Guincho", "Chaveiro"
            'situacao' => $this->faker->boolean(),
        ];
    }
}