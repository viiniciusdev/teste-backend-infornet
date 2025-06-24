<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PrestadorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'logradouro' => $this->faker->streetName(),
            'numero' => $this->faker->buildingNumber(),
            'bairro' => $this->faker->citySuffix(),
            'cidade' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
            'latitude' => $this->faker->latitude(-33, -15),   // ajustado para Brasil
            'longitude' => $this->faker->longitude(-70, -34),
            'situacao' => true
        ];
    }
}
