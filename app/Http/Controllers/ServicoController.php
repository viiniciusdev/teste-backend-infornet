<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServicoController extends Controller
{
    public function index()
    {
        return response()->json(Servico::with('prestadores')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor_base' => 'required|numeric',
            'descricao' => 'nullable|string',
        ]);

        $servico = Servico::create($request->all());
        return response()->json($servico, 201);
    }

    public function show($id)
    {
        $servico = Servico::with('prestadores')->findOrFail($id);
        return response()->json($servico, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'sometimes|string|max:255',
            'valor_base' => 'sometimes|numeric',
            'descricao' => 'nullable|string',
        ]);

        $servico = Servico::findOrFail($id);
        $servico->update($request->all());

        return response()->json($servico, 200);
    }

    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return response()->json(['message' => 'Serviço removido com sucesso.'], 200);
    }

    public function calcularCusto(Request $request)
    {
        $request->validate([
            'cep_origem' => 'required|string|size:9',
            'cep_destino' => 'required|string|size:9',
            'valor_base' => 'required|numeric|min:0',
        ], [
            'cep_origem.required' => 'Informe o CEP de origem.',
            'cep_destino.required' => 'Informe o CEP de destino.',
            'valor_base.required' => 'Informe o valor base.',
        ]);

        try {
            $origem = Http::withoutVerifying()->get("https://viacep.com.br/ws/{$request->cep_origem}/json/")->json();
            $destino = Http::withoutVerifying()->get("https://viacep.com.br/ws/{$request->cep_destino}/json/")->json();

            if (isset($origem['erro']) || isset($destino['erro'])) {
                return response()->json(['error' => 'Um ou ambos os CEPs são inválidos.'], 422);
            }

            $fatorDistancia = (levenshtein($origem['localidade'], $destino['localidade']) + 1) * 5;
            $custoTotal = $request->valor_base + $fatorDistancia;

            return response()->json([
                'origem' => $origem['localidade'],
                'destino' => $destino['localidade'],
                'valor_base' => number_format($request->valor_base, 2, ',', '.'),
                'fator_distancia' => $fatorDistancia,
                'custo_total_estimado' => number_format($custoTotal, 2, ',', '.'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao calcular custo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calcula o valor real do serviço com base nas coordenadas
     */
    public function calcularValorReal(Request $request)
    {
        $request->validate([
            'latitude_origem' => 'required|numeric',
            'longitude_origem' => 'required|numeric',
            'latitude_destino' => 'required|numeric',
            'longitude_destino' => 'required|numeric',
        ]);

        try {
            // Calcula a distância em quilômetros usando a fórmula de Haversine
            $raioTerra = 6371;
            $lat1 = deg2rad($request->latitude_origem);
            $lon1 = deg2rad($request->longitude_origem);
            $lat2 = deg2rad($request->latitude_destino);
            $lon2 = deg2rad($request->longitude_destino);

            $deltaLat = $lat2 - $lat1;
            $deltaLon = $lon2 - $lon1;

            $a = sin($deltaLat / 2) ** 2 +
                cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distanciaKm = $raioTerra * $c;

            // Regra de cálculo
            $valorBase = 30.00;
            $kmAdicional = max(0, $distanciaKm - 5);
            $valorAdicional = $kmAdicional * 5;
            $valorFinal = $valorBase + $valorAdicional;

            return response()->json([
                'distancia_km' => round($distanciaKm, 2),
                'valor_base' => number_format($valorBase, 2, ',', '.'),
                'valor_adicional' => number_format($valorAdicional, 2, ',', '.'),
                'valor_total' => number_format($valorFinal, 2, ',', '.')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao calcular valor real: ' . $e->getMessage()
            ], 500);
        }
    }
}
