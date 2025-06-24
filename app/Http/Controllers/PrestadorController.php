<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrestadorController extends Controller
{
    // LISTAR TODOS OS PRESTADORES
    public function index()
    {
        try {
            $prestadores = Prestador::select('id', 'nome', 'email', 'telefone', 'cidade', 'uf')
                                    ->orderBy('id', 'desc')
                                    ->get();

            return response()->json($prestadores, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar prestadores: ' . $e->getMessage()], 500);
        }
    }

    // CADASTRAR UM NOVO PRESTADOR
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'     => 'required|string|max:255',
            'email'    => 'required|email|unique:prestadores',
            'telefone' => 'required|string|max:20',
            'cpf'      => 'required|string|max:14|unique:prestadores',
            'cep'      => 'nullable|string|max:10',
            'logradouro' => 'nullable|string|max:255',
            'numero'     => 'nullable|string|max:10',
            'bairro'     => 'nullable|string|max:100',
            'cidade'     => 'nullable|string|max:100',
            'uf'         => 'nullable|string|max:2',
            'situacao'   => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $prestador = Prestador::create($request->all());
            return response()->json($prestador, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar prestador: ' . $e->getMessage()], 500);
        }
    }

    // MOSTRAR UM PRESTADOR ESPECÍFICO
    public function show($id)
    {
        try {
            $prestador = Prestador::select('id', 'nome', 'email', 'telefone', 'cidade', 'uf')
                                  ->findOrFail($id);

            return response()->json($prestador, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Prestador não encontrado'], 404);
        }
    }

    // ATUALIZAR UM PRESTADOR
    public function update(Request $request, $id)
    {
        try {
            $prestador = Prestador::findOrFail($id);
            $prestador->update($request->all());

            return response()->json($prestador, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar prestador: ' . $e->getMessage()], 500);
        }
    }

    // DELETAR UM PRESTADOR
    public function destroy($id)
    {
        try {
            Prestador::destroy($id);
            return response()->json(['message' => 'Prestador removido.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir prestador: ' . $e->getMessage()], 500);
        }
    }
}
