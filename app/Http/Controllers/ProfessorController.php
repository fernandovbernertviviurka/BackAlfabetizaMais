<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessorRequest;
use App\Http\Requests\UpdateProfessorRequest;
use App\Models\Professor;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professores = Professor::all();
        return response()->json([
            "success" => true,
            "message" => "Professores",
            "data" => $professores
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
     * @param  \App\Http\Requests\StoreProfessorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessorRequest $request)
    {

        if (Professor::where('email', '=', $request['email'])->exists()) {
            return response()->json([
                "success" => false,
                "message" => "Usuario already exist.",
            ], 400);
        }
        $input = $request->all();
        // $validator = Validator::make($input, [
        //     'name' => 'required',
        //     'detail' => 'required'
        // ]);
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
        $professores = Professor::create($input);
        return response()->json([
            "success" => true,
            "message" => "Professor created successfully.",
            "data" => $professores
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(Professor $professor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $professor = Professor::find($id);
        if (is_null($professor)) {
            return response()->json([
                "success" => true,
                "message" => "Professor not found.",
                "data" => $id
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Professor retrieved successfully.",
            "data" => $professor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessorRequest  $request
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessorRequest $request, Professor $professor, $id)
    {
        $input = $request->all();
        $professor = Professor::find($id);

        // $validator = Validator::make($input, [
        // 'name' => 'required',
        // 'detail' => 'required'
        // ]);
        // if($validator->fails()){
        // return $this->sendError('Validation Error.', $validator->errors());       
        // }
        $professor->update(
            [
                'nome' => $input['nome'],
                'email' => $input['email'],
                'senha' => $input['senha'],
                'especializacao' => $input['especializacao'],

            ]
        );


        return response()->json([
            "success" => true,
            "message" => "Professor updated successfully.",
            "data" => $professor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professor $professor)
    {

        try {
            $professor->delete();
            return response()->json([
                "success" => true,
                "message" => "Professor deleted successfully."
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => $th,
            ], 400);
        }
    }

    public function login(UpdateProfessorRequest $request)
    {
        if (!$request['usuario'] || !$request['senha']) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => "You must enter your username and your password",
            ], 400);
        }
        $countUser  = Professor::where('email', '=', $request['usuario'])->count();
        if ($countUser == 0) {
            return response()->json([
                "success" => false,
                "message" => "Error.",
                "error" => "Professor not found",
            ], 401);
        }
        
        $user = Professor::where('email', '=', $request['usuario'])->get();
        if ($user[0]['email'] == $request['usuario']) {
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
