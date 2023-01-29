<?php

use Domain\Aluno\Controllers\AlunoController;
use Domain\Auth\Controllers\AuthController;
use Domain\Comentario\Controllers\ComentarioController;
use Domain\Disciplina\Controllers\DisciplinaController;
use Domain\Nota\Controllers\NotaController;
use Domain\Presenca\Controllers\PresencaController;
use Domain\Turma\Controllers\TurmaController;
use Domain\Usuario\Controllers\UsuarioController;
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

const AUTH = "auth:sanctum";

/**
 * Authentication
 */

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(AUTH);
Route::get('/me', [AuthController::class, 'me'])->middleware(AUTH);

/**
 * API Routes
 */

Route::apiResource('/usuario', UsuarioController::class)->middleware(AUTH);

Route::apiResource('/aluno', AlunoController::class)->middleware(AUTH);

Route::apiResource('/presenca', PresencaController::class)->middleware(AUTH);
Route::get('/presenca/aluno/{idAluno}', [PresencaController::class, 'showByIdAluno'])->middleware(AUTH);

Route::get('/comentario/aluno', [ComentarioController::class, 'listarComentariosDoAlunoPorResponsavelLogado'])->middleware(AUTH);
Route::get('/comentario/aluno/meu', [ComentarioController::class, 'listarComentariosPorProfessorLogado'])->middleware(AUTH);
Route::apiResource('/comentario', ComentarioController::class)->middleware(AUTH);
Route::get('/comentario/aluno/{idAluno}', [ComentarioController::class, 'listarComentariosPorIdAluno'])->middleware(AUTH);

Route::get('/nota/aluno/{idAluno}', [NotaController::class, 'listarNotasPorIdAluno']);

Route::apiResource('/turma', TurmaController::class);

Route::apiResource('/disciplina', DisciplinaController::class);
