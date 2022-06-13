<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\TurmaHasProva;
use App\Models\Nota;


class DashboardController extends Controller
{

    public function alunosProfessor($id)
    {
        $data = Aluno::join("turma", function ($join) {
            $join->on("aluno.id_turma", "=", "turma.id");
        })
            ->where('turma.id_professor', '=', $id)
            ->count();

            return response()->json([
                "success" => true,
                "message" => "Alunos Professor",
                "data" => $data
            ], 200);
    }

    public function provasCriadasPorProfessor($id)
    {
            $data = TurmaHasProva::join("turma", function ($join) {
                $join->on("turma_has_prova.id_turma", "=", "turma.id");
            })
                ->where('turma.id_professor', '=', $id)
                ->count();

            return response()->json([
                "success" => true,
                "message" => "Provas Criadas Por Professor",
                "data" => $data
            ], 200);
    }

    public function provasCriadasPorProfessorRespondidas($id)
    {
        $data = TurmaHasProva::join("turma", function ($join) {
            $join->on("turma_has_prova.id_turma", "=", "turma.id");
        })
        ->join("nota", function ($join) {
            $join->on("nota.id_prova", "=", "turma_has_prova.id_prova");
        })
            ->where('turma.id_professor', '=', $id)
            ->count();

        return response()->json([
            "success" => true,
            "message" => "Provas Criadas Por Professor Respondidas",
            "data" => $data
        ], 200);
    }

    public function melhoresAlunos($id)
    {
            $data = Nota::join("aluno", function ($join) {
                $join->on("nota.id_aluno", "=", "aluno.id");
            })
            ->join("turma_has_prova", function ($join) {
                $join->on("turma_has_prova.id_prova", "=", "nota.id_prova");
            })
            ->join("turma", function ($join) {
                $join->on("turma.id", "=", "turma_has_prova.id_turma");
            })
                ->where('turma.id_professor', '=', $id)
                ->orderByDesc('nota','data_finalizacao')
                ->take(5)->get();

           return response()->json([
               "success" => true,
               "message" => "Melhores Alunos",
               "data" => $data
           ], 200);
    }
}
