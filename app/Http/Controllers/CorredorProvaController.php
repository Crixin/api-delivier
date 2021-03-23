<?php

namespace App\Http\Controllers;

use App\Models\{CorredorProva, Prova};
use Illuminate\Http\Request;
use App\Services\ValidationService;

class CorredorProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CorredorProva::orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = new ValidationService(CorredorProva::rules(), $request->all());
            $errors = $validator->make();

            if ($errors) {
                throw new \Exception($errors->messages()->all());
            }

            $provasCadastradasCorredor = CorredorProva::where([
                ["corredor_id", "=", $request->corredor_id],
            ])->pluck('prova_id')->toArray();
            
            $provaNova = Prova::findOrFail($request->prova_id);

            $datasProvasParticipantes = Prova::whereIn("id", $provasCadastradasCorredor)->pluck('data')->toArray();
            
            if (in_array($provaNova->data, $datasProvasParticipantes)) {
                throw new \Exception("O corredor não pode ter duas corridas no mesmo dia.");
            }
            
            $corredorProva = CorredorProva::create($request->all());
            return response()->json(['data' => $corredorProva]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($corredorProva)
    {
        try {
            return response()->json(['data' => CorredorProva::findOrFail($corredorProva)]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($corredorProva)
    {
        try {
            $corredorProva = CorredorProva::findOrFail($corredorProva);
            $corredorProva->delete();

            return response()->json(['data' => $corredorProva]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
