<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/inserir', [ClienteController::class, 'inserirCliente']);
Route::post('/alterar', [ClienteController::class, 'alterarCliente']);
Route::get('/buscar-todos', [ClienteController::class, 'buscarTodosClientes']);
Route::get('/enviar-emails', [ClienteController::class, 'enviarEmails']);
