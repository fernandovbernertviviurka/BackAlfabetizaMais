<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Exercicio;
use App\Models\Turma;
use App\Models\TurmaHasProva;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{

    public function geraRelatorio(Request $request)
    {

        $query = DB::table('aluno')
        ->join('turma_has_prova', 'aluno.id_turma', '=', 'turma_has_prova.id_turma')
        ->join('turma', 'turma_has_prova.id_turma', '=', 'turma.id')
        ->join('prova', 'turma_has_prova.id_prova', '=', 'prova.id')
        ->join('nota', 'nota.id_prova', '=', 'prova.id');

        if ($request['aluno'] && !$request['turma'] && !$request['prova']) {
            $query->where('aluno.nome','like', '%'.$request['aluno'].'%');
        }
        if (!$request['aluno'] && $request['turma'] && !$request['prova']){
                $query->where('turma.nome', 'like', '%'.$request['turma'].'%');
        }
        if(!$request['aluno'] && !$request['turma'] && $request['prova']){
                $query->where('prova.titulo', 'like', '%'.$request['prova'].'%');
        }
        if($request['aluno'] && $request['turma'] && !$request['prova']){
                $query->where('aluno.nome', 'like', '%'.$request['aluno'].'%');
                $query->where('turma.nome', 'like', '%'.$request['turma'].'%');
        }
        if($request['aluno'] && !$request['turma'] && $request['prova']){
                $query->where('aluno.nome', 'like', '%'.$request['aluno'].'%');
                $query->where('prova.titulo', 'like', '%'.$request['prova'].'%');
        }
        if(!$request['aluno'] && $request['turma'] && $request['prova']){
                $query->where('turma.nome', 'like', '%'.$request['turma'].'%');
                $query->where('prova.titulo', 'like', '%'.$request['prova'].'%');
        }
        if($request['aluno'] && $request['turma'] && $request['prova']){
                $query->where('aluno.nome', 'like', '%'.$request['aluno'].'%');
                $query->where('turma.nome', 'like', '%'.$request['turma'].'%');
                $query->where('prova.titulo', 'like', '%'.$request['prova'].'%');
        }

        $result= $query->get();
            
            return response()->json([
                "success" => true,
                "message" => "Relatório Aluno",
                "data" => $result
            ], 200);
    }
}
