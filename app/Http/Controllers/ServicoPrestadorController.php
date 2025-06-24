<?php

namespace App\Http\Controllers;

use App\Models\ServicoPrestador;
use Illuminate\Http\Request;

class ServicoPrestadorController extends Controller
{
    /**
     * Lista todas as relações entre serviços e prestadores.
     */
    public function index()
    {
        return response()->json(ServicoPrestador::with(['servico', 'prestador'])->get(), 200);
    }

    /**
     * Cria uma nova relação entre serviço e prestador.
     */
    public function store(Request $request)
    {
        $request->validate([
            'servico_id' => 'required|exists:servicos,id',
            'prestador_id' => 'required|exists:prestadores,id',
        ]);

        $relacao = ServicoPrestador::create($request->all());

        return response()->json($relacao, 201);
    }

    /**
     * Exibe uma relação específica.
     */
    public function show($id)
    {
        $relacao = ServicoPrestador::with(['servico', 'prestador'])->findOrFail($id);
        return response()->json($relacao, 200);
    }

    /**
     * Remove uma relação.
     */
    public function destroy($id)
    {
        $relacao = ServicoPrestador::findOrFail($id);
        $relacao->delete();

        return response()->json(['message' => 'Relação removida com sucesso.'], 200);
    }
}
