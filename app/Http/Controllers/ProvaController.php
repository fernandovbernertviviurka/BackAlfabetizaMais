<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvaRequest;
use App\Http\Requests\UpdateProvaRequest;
use App\Models\ExercicioProva;
use App\Models\Exercicio;
use App\Models\ExercicioTipoSeis;
use App\Models\Prova;
use App\Models\Turma;
use App\Models\TurmaHasProva;
use \stdClass;

class ProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prova = Prova::all();
        return response()->json([
            "success" => true,
            "message" => "Professores",
            "data" => $prova
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
     * @param  \App\Http\Requests\StoreProvaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProvaRequest $request)
    {

        try {
            $prova = new Prova;
            $prova->titulo = $request['titulo'];
            $prova->media = $request['media'];
            $prova->data_liberacao = $request['data_liberacao'];
            $prova->date_encerramento = $request['date_encerramento'];
            $prova->quantidade_tentativas = $request['quantidade_tentativas'];
            $prova->save();

            if ($request['id_turma']) {
                $turmaHasProva = new TurmaHasProva;
                $turmaHasProva->id_turma = $request['id_turma'];
                $turmaHasProva->id_prova = $prova->id;
                $turmaHasProva->save();
            }

            return response()->json([
                "success" => true,
                "message" => "Prova created successfully.",
                "data" => $prova
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                "success" => true,
                "message" => "Prova dont created.",
                "data" => $th
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prova  $prova
     * @return \Illuminate\Http\Response
     */
    public function show(Prova $prova)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prova  $prova
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prova = Prova::find($id);
        if (is_null($prova)) {
            return response()->json([
                "success" => false,
                "message" => "Prova not found.",
                "data" => $id
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Prova retrieved successfully.",
            "data" => $prova
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProvaRequest  $request
     * @param  \App\Models\Prova  $prova
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProvaRequest $request, Prova $prova, $id)
    {
        $input = $request->all();
        $prova = Prova::find($id);
        $prova->update(
            [
                'titulo' => $input['titulo'],
                'media' => $input['media'],
                'data_liberacao' => $input['data_liberacao'],
                'data_encerramento' => $input['date_encerramento'],
                'quantidade_tentativas' => $input['quantidade_tentativas'],
            ]
        );


        return response()->json([
            "success" => true,
            "message" => "Prova updated successfully.",
            "data" => $prova
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prova  $prova
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prova $prova)
    {
        try {
            $prova->delete();
            return response()->json([
                "success" => true,
                "message" => "Prova deleted successfully."
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => $th,
            ], 400);
        }
    }

    public function getProvasDisponiveis($turma_id)
    {
        try {

            $idProva = collect(TurmaHasProva::where('id_turma', '=', $turma_id)->get());
            for ($i = 0; $i < count($idProva); $i++) {

                $prova = Prova::where('id', '=', $idProva[$i]['id_prova'])
                    ->whereDate('data_liberacao', '<=', date('Y-m-d'))
                    ->whereDate('date_encerramento', '<=', date('Y-m-d'))
                    ->where('quantidade_tentativas', '>', '0')
                    ->get()
                    ->toArray();
                if (sizeof($prova) != 0) {
                    foreach ($prova as $pr) {
                        $arr[] = [
                            'prova' => $pr
                        ];
                    }
                }
            }

            return response()->json($arr);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => $th,
            ], 400);
        }
    }

    public function getExerciciosPorProva($id)
    {
        $valor_prova = 0;
        $this->removeTentativa($id);
        $prova = ExercicioProva::where('id_prova', '=', $id)->get()->toArray();
        if (count($prova) == 0) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => 'No exercise in this task',
            ], 400);
        }
        for ($i = 0; $i < count($prova); $i++) {
            $arr[$i]['prova'] = $prova[$i];
            $valor_prova = $prova[$i]['valor_exercicio'] + $valor_prova;
            $exercicio = Exercicio::where('id', '=', $prova[$i]['id_exercicio'])->get()->toArray();
            $arr[$i]['prova']['exercicio'] = $exercicio[0];
            if ($exercicio[0]['tipo_exercicio'] == 6) {
                $exercicioSeisImagem = ExercicioTipoSeis::where('id_exercicio', '=', $exercicio[0]['id'])->get();
                for ($j = 0; $j < count($exercicioSeisImagem); $j++) {
                    $exerTipoSeis[$j] = $exercicioSeisImagem[$j];
                }
                $arr[$i]['prova']['exercicio']['exercicioTipoSeis'] = (object) $exerTipoSeis;
            }
        }
        $this->setNewValorToProva($valor_prova, $id);
        return response()->json($arr);
    }

    public function removeTentativa($id)
    {
        return Prova::where('id', '=', $id)->decrement('quantidade_tentativas', 1);
    }

    public function setNewValorToProva($valor_prova, $id)
    {
        return Prova::where('id', $id)->update(['valor_prova' => $valor_prova]);
    }
}
