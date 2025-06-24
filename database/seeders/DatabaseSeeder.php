<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Prestador;
use App\Models\Servico;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria o usuário para login
        Usuario::factory()->create([
            'nome' => 'Test User',
            'email' => 'teste@email.com',
            'password' => Hash::make('123456'),
        ]);

        // Cria 5 serviços
        $servicos = Servico::factory(5)->create();

        // Cria 25 prestadores e associa 3 serviços aleatórios a cada um
        Prestador::factory(25)->create()->each(function ($prestador) use ($servicos) {
            $servicosAleatorios = $servicos->random(3);

            foreach ($servicosAleatorios as $servico) {
                $prestador->servicos()->attach($servico->id, [
                    'km_saida' => rand(10, 30),
                    'valor_saida' => rand(50, 150),
                    'valor_km_excedente' => rand(5, 20)
                ]);
            }
        });
    }
}
