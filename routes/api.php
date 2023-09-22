<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/fornecedores', FornecedorController::class);
    Route::resource('/clientes', ClienteController::class);
    Route::resource('/funcoes', FuncaoController::class);
    Route::resource('/permissoes', PermissaoController::class);
    Route::resource('/produtos', ProdutoController::class);
    Route::resource('/colaboradores', ColaboradorController::class);
    Route::get('/colaborador/funcao/{id}', [ColaboradorController::class, 'getFuncaoById']);
    Route::resource('/vendas', VendaController::class);
});

Route::post('/login', [AuthController::class, 'login']);
