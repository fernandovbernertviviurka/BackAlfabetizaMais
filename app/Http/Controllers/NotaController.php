<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Models\Nota;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nota = Nota::all();
        return response()->json([
            "success" => true,
            "message" => "Nota",
            "data" => $nota
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotaRequest $request)
    {
        try {
            $nota = new Nota;
            $nota->id_aluno = $request['id_aluno'];
            $nota->id_prova = $request['id_prova'];
            $nota->nota = $request['nota'];
            $nota->data_finalizacao = date('Y-m-d');
            $nota->exercisethree = $request['exercisethree'];
            $nota->save();


            return response()->json([
                "success" => true,
                "message" => "Nota added successfully.",
                "data" => $nota
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                "success" => true,
                "message" => "Nota dont added.",
                "data" => $th
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit(Nota $nota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotaRequest  $request
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotaRequest $request, Nota $nota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        //
    }

    public function getNotaPorAluno($id)
    {

        try {

            $data = Nota::join("prova", function ($join) {
                $join->on("prova.id", "=", "nota.id_prova");
            })
                ->where('prova.valor_prova', '>=', 0)
                ->get([
                    'nota.nota',
                    'nota.data_finalizacao',
                    'prova.titulo',
                    'prova.media',
                    'prova.valor_prova'
                ]);

            foreach ($data as $resp) {
                $valor_aprovacao = $resp->valor_prova * $resp->media / 10;
                $resultado = "Abaixo da media";
                if ($resp->nota > $valor_aprovacao && $resp->nota != $resp->valor_prova) {
                    $resultado = "Acima da media";
                } elseif ($resp->nota == $valor_aprovacao) {
                    $resultado = "Na media";
                }

                $resp->resultado = $resultado;
            }


            return response()->json($data, 200);
        } catch (\Throwable $th) {

            return response()->json([
                "success" => true,
                "message" => "Nota dont added.",
                "data" => $th
            ], 400);
        }
    }
}
