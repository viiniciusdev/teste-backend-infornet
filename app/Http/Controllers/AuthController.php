<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Realiza o login e retorna o token JWT.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        return response()->json([
            'token' => $token,
            'usuario' => auth()->user()->nome
        ]);
    }

    /**
     * Retorna o usuário logado.
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Realiza o logout e invalida o token.
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * Faz refresh do token JWT.
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'token' => auth()->refresh(),
            'usuario' => auth()->user()->nome
        ]);
    }
}
