<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrestadorController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ServicoPrestadorController;
use App\Http\Controllers\EnderecoController;

// ===================================================================
//  ROTAS PÚBLICAS (Login e Geolocalização via proxy sem CORS)
// ===================================================================

Route::post('/login', [AuthController::class, 'login'])->name('login');


// ===================================================================
//  ROTAS PROTEGIDAS POR JWT
// ===================================================================

Route::middleware('auth:api')->group(function () {

    // Autenticação
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Consulta de prestadores (com base em localização e serviço)
    Route::post('/prestadores/consulta', [PrestadorController::class, 'consulta']);

    // CRUDs protegidos
    Route::apiResource('prestadores', PrestadorController::class);
    Route::apiResource('servicos', ServicoController::class);
    Route::apiResource('servico-prestadores', ServicoPrestadorController::class);

    // Cálculos baseados em distância
    Route::post('/servicos/calcular-custo', [ServicoController::class, 'calcularCusto']);
    Route::post('/servicos/calcular-valor-real', [ServicoController::class, 'calcularValorReal']);

    // (Opcional) rota interna caso use o EnderecoController
    Route::post('/enderecos/geolocalizar', [EnderecoController::class, 'geolocalizar']);
});