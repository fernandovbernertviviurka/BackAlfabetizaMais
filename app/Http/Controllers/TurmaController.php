<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTurmaRequest;
use App\Http\Requests\UpdateTurmaRequest;
use App\Models\Turma;
use App\Models\Professor;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turma = Turma::all();
        return response()->json([
            "success" => true,
            "message" => "Turma",
            "data" => $turma
        ],200);
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
     * @param  \App\Http\Requests\StoreTurmaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTurmaRequest $request)
    {
        $input = $request->all();
        // $validator = Validator::make($input, [
        //     'name' => 'required',
        //     'detail' => 'required'
        // ]);
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }

        if (Professor::where('id', '=', $input['id_professor'])->exists()) {
            try {
                $turma = new Turma;
                $turma->nome = $request['nome'];
                $turma->quantidade_alunos = $request['quantidade_alunos'];
                $turma->id_professor = $request['id_professor'];
                $turma->save();
    
                return response()->json([
                    "success" => true,
                    "message" => "Professor created successfully.",
                    "data" => $turma
                ],200);  
            } catch (\Throwable $th) {
                return response()->json([
                    "success" => true,
                    "message" => "Turma dont created.",
                    "data" => $request
                ], 400);  
            }
               
        }else{
            return response()->json([
                "success" => true,
                "message" => "Professor dont exist.",
                "data" => $request['id_professor']
            ], 400);   
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function show(Turma $turma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $turma = Turma::find($id);
        if (is_null($turma)) {
            return response()->json([
                "success" => true,
                "message" => "Turma not found.",
                "data" => $id
            ]);        
        }
        return response()->json([
            "success" => true,
            "message" => "Turma retrieved successfully.",
            "data" => $turma
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTurmaRequest  $request
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTurmaRequest $request, Turma $turma)
    {
        try {
            $turma->update(
                [
                    'nome' => $request['nome'],
                    'quantidade_alunos' => $request['emaquantidade_alunosil'],
                    'id_professor' => $request['id_professor'],
    
                ]);
    
            return response()->json([
                "success" => true,
                "message" => "Professor updated successfully.",
                "data" => $turma
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "data" => $th
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $turma = Turma::findOrFail($id);
            $turma->delete();
            return response()->json([
                "success" => true,
                "message" => "Turma deleted successfully."
            ]);        
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => $th,
            ], 400);   
        }
        
    }

    public function getTurmaByProfessor($id){

        $turma = Turma::where('id_professor', '=', $id)->get();
        dd($turma);

    }
}
