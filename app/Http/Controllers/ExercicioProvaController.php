<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExercicioProvaRequest;
use App\Http\Requests\UpdateExercicioProvaRequest;
use App\Models\ExercicioProva;

class ExercicioProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreExercicioProvaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExercicioProvaRequest $request)
    {
        try {
            $exercicioProva = new ExercicioProva();
            $exercicioProva->id_prova = $request['id_prova'];
            $exercicioProva->id_exercicio = $request['id_exercicio'];
            $exercicioProva->ordem = $request['ordem'];
            $exercicioProva->valor_exercicio = $request['valor_exercicio'];
            $exercicioProva->save();


            return response()->json([
                "success" => true,
                "message" => "Exercicio Prova created successfully.",
                "data" => $exercicioProva
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
     * @param  \App\Models\ExercicioProva  $exercicioProva
     * @return \Illuminate\Http\Response
     */
    public function show(ExercicioProva $exercicioProva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExercicioProva  $exercicioProva
     * @return \Illuminate\Http\Response
     */
    public function edit(ExercicioProva $exercicioProva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExercicioProvaRequest  $request
     * @param  \App\Models\ExercicioProva  $exercicioProva
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExercicioProvaRequest $request, ExercicioProva $exercicioProva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExercicioProva  $exercicioProva
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExercicioProva $exercicioProva)
    {
        //
    }
}
