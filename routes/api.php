<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/usuario', UsuarioController::class);
Route::apiResource('/aluno', AlunoController::class);
Route::apiResource('/presenca', PresencaController::class);
Route::get('/presenca/aluno/{idAluno}', [PresencaController::class, 'showByIdAluno']);
