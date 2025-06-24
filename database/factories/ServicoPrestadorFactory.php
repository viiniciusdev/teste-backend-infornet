<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Servico;
use App\Models\Prestador;

class ServicoPrestadorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_prestador' => Prestador::factory(), // caso precise usar standalone
            'id_servico' => Servico::inRandomOrder()->first()?->id ?? 1,
            'km_saida' => $this->faker->numberBetween(10, 30),
            'valor_saida' => $this->faker->randomFloat(2, 20, 100),
            'valor_km_excedente' => $this->faker->randomFloat(2, 5, 15),
        ];
    }
}
