<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnderecoController extends Controller
{
    

    /**
     * Consulta coordenadas a partir de partes separadas do endereço.
     */
    public function geolocalizar(Request $request)
    {
        $request->validate([
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
        ]);

        $enderecoCompleto = urlencode("{$request->logradouro}, {$request->numero}, {$request->cidade}, {$request->estado}");

        try {
            $response = Http::withOptions([
                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem', // ← mesmo ajuste
            ])
            ->withBasicAuth('teste-Infornet', 'c@nsulta-dad0s-ap1-teste-Infornet#24')
            ->timeout(10)
            ->get("https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/endereco/geocode/{$enderecoCompleto}");

            if ($response->failed()) {
                return response()->json(['error' => 'Erro ao buscar coordenadas.'], 502);
            }

            $dados = $response->json();

            return response()->json([
                'latitude' => $dados['latitude'] ?? null,
                'longitude' => $dados['longitude'] ?? null,
                'localizacao_formatada' => $dados['localizacao_formatada'] ?? "{$request->logradouro}, {$request->numero}, {$request->cidade} - {$request->estado}"
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar coordenadas: ' . $e->getMessage()], 500);
        }
    }
}
