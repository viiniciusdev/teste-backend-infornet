<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestador;
use App\Models\Servico;
use App\Models\ServicoPrestador;

class PrestadorSeeder extends Seeder
{
    public function run(): void
    {
        $servicos = Servico::all();

        Prestador::factory(25)->create()->each(function ($prestador) use ($servicos) {
            $servicosAleatorios = $servicos->random(3);

            foreach ($servicosAleatorios as $servico) {
                ServicoPrestador::create([
                    'id_prestador' => $prestador->id,
                    'id_servico' => $servico->id,
                    'km_saida' => rand(10, 30),
                    'valor_saida' => rand(50, 100),
                    'valor_km_excedente' => rand(5, 15),
                ]);
            }
        });
    }
}
