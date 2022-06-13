<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use App\Models\Aluno;
use App\Models\Turma;


class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aluno = Aluno::all();
        return response()->json([
            "success" => true,
            "message" => "Aluno",
            "data" => $aluno
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
     * @param  \App\Http\Requests\StoreAlunoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlunoRequest $request)
    {
        if (Aluno::where('usuario', '=', $request['usuario'])->exists()) {
            return response()->json([
                "success" => false,
                "message" => "Aluno already exist.",
            ], 400);
        }
        try {

            $aluno = new Aluno;
            $aluno->id_turma = $request['id_turma'];
            $aluno->nome = $request['nome'];
            $aluno->usuario = $request['usuario'];
            $aluno->senha = $request['senha'];
            $aluno->idade = $request['idade'];
            $aluno->nome_completo_responsavel = $request['nome_completo_responsavel'];
            $aluno->email_responsavel = $request['email_responsavel'];
            $aluno->save();

            return response()->json([
                "success" => true,
                "message" => "Aluno created successfully.",
                "data" => $aluno
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Aluno dont created.",
                "data" => $th
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function show(Aluno $aluno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aluno = Aluno::find($id);
        if (is_null($aluno)) {
            return response()->json([
                "success" => true,
                "message" => "Aluno not found.",
                "data" => $id
            ], 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Turma retrieved successfully.",
            "data" => $aluno
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlunoRequest  $request
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlunoRequest $request, Aluno $aluno, $id)
    {
        try {

            $alunoNome = Aluno::where("id", "=", $id)->get('usuario');

            $aluno->where('id', $id)
                ->update(
                    [
                        'nome' => $request['nome'],
                        'usuario' => $alunoNome[0]->usuario,
                        'senha' => $request['senha'],
                        'idade' => $request['idade'],
                        'nome_completo_responsavel' => $request['nome_completo_responsavel'],
                        'email_responsavel' => $request['email_responsavel'],
                    ]
                );
            return response()->json([
                "success" => true,
                "message" => "Aluno updated successfully.",
                "data" => $aluno
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
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $aluno = Aluno::findOrFail($id);
            $aluno->delete();
            return response()->json([
                "success" => true,
                "message" => "Aluno deleted successfully."
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => $th,
            ], 400);
        }
    }

    public function login(UpdateAlunoRequest $request)
    {
        if (!$request['usuario'] || !$request['senha']) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => "You must enter your username and your password",
            ], 400);
        }

        $countUser  = Aluno::where('usuario', '=', $request['usuario'])->count();
        $user = Aluno::where('usuario', '=', $request['usuario'])->get();

        if ($countUser == 0) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => "Aluno not found",
            ], 401);
        }
        if ($user[0]['usuario'] == $request['usuario']) {
            if ($user[0]['senha'] != $request['senha']) {
                return response()->json([
                    "success" => false,
                    "message" => "Error.",
                    "error" => "Wrong password!",
                ], 401);
            }
            return response()->json([
                "success" => true,
                "message" => "Auth made with success.",
                "user" => $user
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => "Wrong username!",
            ], 401);
        }
    }
}
