<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExercicioRequest;
use App\Http\Requests\UpdateExercicioRequest;
use App\Models\Exercicio;
use App\Models\ExercicioTipoSeis;

class ExercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exercicio = Exercicio::all();
        return response()->json([
            "success" => true,
            "message" => "Exercicio",
            "data" => $exercicio
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExercicioRequest $request)
    {
        try {
            
            $exercicio = $this->switchFieldsAsExerciseType($request);
            if ($exercicio->tipo_exercicio == 6) {
                $exercicioTipoSeis = ExercicioTipoSeis::where('id_exercicio','=', $exercicio->id)->get();
                $fullExercicio = [
                    'exercicio' => $exercicio,
                    'exercicioseis' => $exercicioTipoSeis
                ];
                return response()->json([
                    "success" => true,
                    "message" => "Exercise create.",
                    "data" => $fullExercicio
                ], 200);
            }else{
                return response()->json([
                    "success" => true,
                    "message" => "Exercise create.",
                    "data" => $exercicio
                ], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Exercise dont created.",
                "data" => $th
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exercicio  $exercicio
     * @return \Illuminate\Http\Response
     */
    public function show(Exercicio $exercicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exercicio  $exercicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercicio $exercicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExercicioRequest  $request
     * @param  \App\Models\Exercicio  $exercicio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExercicioRequest $request, Exercicio $exercicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exercicio  $exercicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercicio $exercicio)
    {
        //
    }

    public function switchFieldsAsExerciseType($request)
    {

        switch ($request['tipo_exercicio']) {
            case '1':
            case '2':
                return $this->exerciseTypeOne($request);
            case '3':
                return $this->exerciseTypeThree($request);
            case '4':
                return $this->exerciseTypeFour($request);
            case '5':
                return $this->exerciseTypeFive($request);
            case '6':
                return $this->exerciseTypeSix($request);
            case '0':
                return response()->json([
                    "success" => true,
                    "message" => "Exercicio",
                    "data" => "Exercise Cant Be 0"
                ], 200);
            default:
                return response()->json([
                    "success" => true,
                    "message" => "Exercicio",
                    "data" => "Exercise Type Doenst Exist"
                ], 200);
        }
    }

    public function exerciseTypeOne($request)
    {

        $exercicio = new Exercicio;
        $exercicio->name = $request['name'];
        $exercicio->materia = $request['materia'];

        $exercicio->tipo_exercicio = $request['tipo_exercicio'];
        $exercicio->enunciado = $request['enunciado'];
        if ($request['texto_auxiliar']) {
            $exercicio->texto_auxiliar = $request['texto_auxiliar'];
        }
        if ($request->file('imagem_enunciado')) {
            $exercicio->imagem_enunciado = $this->saveImagem($request);;
        }
        $exercicio->enunciado_questao_a = $request['enunciado_questao_a'];
        $exercicio->enunciado_questao_b = $request['enunciado_questao_b'];
        $exercicio->enunciado_questao_c = $request['enunciado_questao_c'];
        $exercicio->enunciado_questao_d = $request['enunciado_questao_d'];
        $exercicio->enunciado_questao_e = $request['enunciado_questao_e'];

        $exercicio->resposta_questao = $request['resposta_questao'];

        $exercicio->save();
        return $exercicio;
    }

    public function exerciseTypeThree($request)
    {

        $exercicio = new Exercicio;
        $exercicio->name = $request['name'];
        $exercicio->materia = $request['materia'];

        $exercicio->tipo_exercicio = $request['tipo_exercicio'];
        $exercicio->enunciado = $request['enunciado'];
        if ($request['texto_auxiliar']) {
            $exercicio->texto_auxiliar = $request['texto_auxiliar'];
        }
        if ($request->file('imagem_enunciado')) {
            $exercicio->imagem_enunciado = $this->saveImagem($request);;
        }
        $exercicio->save();
        return $exercicio;
    }

    public function exerciseTypeFour($request)
    {

        $exercicio = new Exercicio;
        $exercicio->name = $request['name'];
        $exercicio->materia = $request['materia'];

        $exercicio->tipo_exercicio = $request['tipo_exercicio'];
        $exercicio->enunciado = $request['enunciado'];
        if ($request['texto_auxiliar']) {
            $exercicio->texto_auxiliar = $request['texto_auxiliar'];
        }
        if ($request->file('imagem_enunciado')) {
            $exercicio->imagem_enunciado = $this->saveImagem($request);;
        }
        $exercicio->numero_a = $request['numero_a'];
        $exercicio->numero_b = $request['numero_b'];
        $exercicio->operacao = $request['operacao'];
        $exercicio->resposta_questao = $request['resposta_questao'];

        $exercicio->save();
        return $exercicio;
    }

    public function exerciseTypeFive($request)
    {

        $exercicio = new Exercicio;
        $exercicio->name = $request['name'];
        $exercicio->materia = $request['materia'];

        $exercicio->tipo_exercicio = $request['tipo_exercicio'];
        $exercicio->enunciado = $request['enunciado'];
        if ($request['texto_auxiliar']) {
            $exercicio->texto_auxiliar = $request['texto_auxiliar'];
        }
        if ($request->file('imagem_enunciado')) {
            $exercicio->imagem_enunciado = $this->saveImagem($request);;
        }
        $exercicio->numero_minimo = $request['numero_minimo'];
        $exercicio->numero_maximo = $request['numero_maximo'];
        $exercicio->resposta_questao = $request['resposta_questao'];

        $exercicio->save();
        return $exercicio;
    }

    public function exerciseTypeSix($request)
    {

        $exercicio = new Exercicio;
        $exercicio->name = $request['name'];
        $exercicio->materia = $request['materia'];

        $exercicio->tipo_exercicio = $request['tipo_exercicio'];
        $exercicio->enunciado = $request['enunciado'];

        if ($request['texto_auxiliar']) {
            $exercicio->texto_auxiliar = $request['texto_auxiliar'];
        }
        $exercicio->save();
        for ($i=0; $i < count($request['exercicioTipoSeis']); $i++) { 
            $exercicioTypeSix = new ExercicioTipoSeis;
            $exercicioTypeSix->id_exercicio = $exercicio->id;
            $exercicioTypeSix->imagem = $request['exercicioTipoSeis'][$i]['imagem'];
            $exercicioTypeSix->resposta = $request['exercicioTipoSeis'][$i]['resposta'];
            $exercicioTypeSix->save();
        }

        return $exercicio;
    }

    public function saveImagem($request){
        $file = $request->file('imagem_enunciado')->store('public/documents');
        $getImage = $request->file('imagem_enunciado');
        $imageName = time().'.'.$getImage->extension();
        $imagePath = public_path(). '/images/exercicios/enunciados';
        $getImage->move($imagePath, $imageName);
        return $imageName;

    }
}   
