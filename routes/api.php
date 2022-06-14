<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\NotaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\RelatorioController;

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

Route::prefix('v1')->group(function () {

    Route::prefix('willian')->group(function () {
        Route::get('/', function () {
            return "funfante";
        });
    });

    Route::prefix('login')->group(function () {
        Route::post('/professor', [ProfessorController::class, 'login']);
        Route::post('/aluno', [AlunoController::class, 'login']);
    });

    Route::prefix('professor')->group(function () {
        Route::get('/', [ProfessorController::class, 'index']);
        Route::post('/', [ProfessorController::class, 'store']);
        Route::get('/{id}', [ProfessorController::class, 'edit']);
        Route::delete('/{id}', [ProfessorController::class, 'destroy']);
        Route::put('/{id}', [ProfessorController::class, 'update']);


    });

    Route::prefix('turma')->group(function () {
        Route::get('/', [TurmaController::class, 'index']);
        Route::post('/', [TurmaController::class, 'store']);
        Route::get('/{id}', [TurmaController::class, 'edit']);
        Route::delete('/{id}', [TurmaController::class, 'destroy']);
        Route::put('/{id}', [TurmaController::class, 'update']);

        Route::get('/turmaporprofessor/{id}', [TurmaController::class, 'getTurmaByProfessor']);

    });

    Route::prefix('aluno')->group(function () {
        Route::get('/', [AlunoController::class, 'index']);
        Route::post('/', [AlunoController::class, 'store']);
        Route::get('/{id}', [AlunoController::class, 'edit']);
        Route::delete('/{id}', [AlunoController::class, 'destroy']);
        Route::put('/{id}', [AlunoController::class, 'update']);
    });

    Route::prefix('exercicio')->group(function () {
        Route::get('/', [ExercicioController::class, 'index']);
        Route::post('/', [ExercicioController::class, 'store']);
        Route::delete('/{id}', [ExercicioController::class, 'destroy']);
    });

    Route::prefix('nota')->group(function () {
        Route::get('/', [NotaController::class, 'index']);
        Route::post('/', [NotaController::class, 'store']);
        Route::get('/notaaluno/{id}', [NotaController::class, 'getNotaPorAluno']);

    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/alunosProfessor/{id}', [DashboardController::class, 'alunosProfessor']);
        Route::get('/exerciciosCriados', [DashboardController::class, 'exerciciosCriados']);
        Route::get('/provasCriadasPorProfessor/{id}', [DashboardController::class, 'provasCriadasPorProfessor']);
        Route::get('/provasCriadasPorProfessorRespondidas/{id}', [DashboardController::class, 'provasCriadasPorProfessorRespondidas']);
        Route::get('/melhoresAlunos/{id}', [DashboardController::class, 'melhoresAlunos']);
    });

    Route::prefix('relatorio')->group(function () {
        Route::post('/', [RelatorioController::class, 'geraRelatorio']);
    });

    Route::prefix('prova')->group(function () {
        Route::get('/', [ProvaController::class, 'index']);
        Route::post('/', [ProvaController::class, 'store']);
        Route::get('/{id}', [ProvaController::class, 'edit']);
        Route::delete('/{id}', [ProvaController::class, 'destroy']);
        Route::put('/{id}', [ProvaController::class, 'update']);

        Route::get('/provasdisponiveisporturma/{id}', [ProvaController::class, 'getProvasDisponiveis']);
        Route::get('/exerciciosporprova/{id}', [ProvaController::class, 'getExerciciosPorProva']);
    });
});
